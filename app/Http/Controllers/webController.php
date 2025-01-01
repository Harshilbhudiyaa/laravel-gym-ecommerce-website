<?php

namespace App\Http\Controllers;
use App\Mail\ResetPassword;
use App\Models\contact;
use App\Models\register;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\aboutus;
use App\Models\orders;
use App\Models\service;
use App\Models\MembershipPlan;
use App\Models\memberships;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\slider;
use App\Models\trainer;
use App\Models\product;
use App\Models\Cart;

use App\Http\Controllers\DB;

class webController extends Controller
{
    public function welcome()
    {
        $sliders = Slider::all();
        $trainers = Trainer::all(); 
        $services = Service::all();
        $image = aboutus::select('img')->first();
        $data = aboutus::take(3)->get();
        $membershipPlans = MembershipPlan::all();

        return view('index', compact('sliders', 'trainers', 'services', 'data', 'image','membershipPlans'));
    }


    public function showForm()
    {


        return view('index');
    }


    public function calculateBMI(Request $request)
    {
        $sliders = Slider::all();
        $trainers = Trainer::all(); 
        $services = Service::all();
        $image = aboutus::select('img')->first();
        $data = aboutus::take(3)->get();
        $membershipPlans = MembershipPlan::all();

        $request->validate([
            'height' => 'required|numeric|min:30|max:300',
            'weight' => 'required|numeric|min:1|max:500',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:Male,Female',
        ]);

        $height = $request->input('height');
        $weight = $request->input('weight');
        $age = $request->input('age');
        $gender = $request->input('gender');

        $bmi = $weight / (($height / 100) ** 2);

        if ($bmi < 18.5) {
            $category = 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            $category = 'Normal weight';
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            $category = 'Overweight';
        } else {
            $category = 'Obesity';
        }

        return view('index', [
            'bmi' => number_format($bmi, 2),
            'category' => $category,
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'gender' => $gender,
        ],compact('sliders', 'trainers', 'services', 'data', 'image','membershipPlans'));

    }

    public function About()
    {

        // $data = aboutus::first();
        $image = aboutus::select('img')->first();
        $data = aboutus::take(3)->get();

        return view('about', compact('data', 'image'));
    }

    public function service()
    {

        $services = Service::all();
        return view('service', compact('services'));
    }

  

    public function showForm_cont()
    {
        return view('contact');
    }
    public function submitForm_cont(Request $request)
    {

        $request->validate([
            'name' => 'required|max:20|min:2|alpha',
            'email' => 'required|email',
            'message' => 'required',
        ]);


        $con = new contact();
        $con->name = $request->name;
        $con->email = $request->email;
        $con->message = $request->message;


        if ($con->save()) {
            return redirect('/contact')->with('success', 'Thank you for your message. We will get back to you soon.');
        }

        return redirect('/contact')->with('error', 'There was an issue submitting your message. Please try again.');
    }




    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z\s.]+$/',
        'email' => 'required|email|unique:register,email',
        'phone' => 'required|string|max:20',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'dob' => 'required|date',
        'gender' => 'required|in:male,female',
        'address' => 'required|string|max:255',
        'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif'
    ]);

    if ($request->hasFile('profile_pic')) {
        $image = $request->file('profile_pic');
        $profilePath = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('img/profile'), $profilePath);
    } else {
        $profilePath = 'default.jpg';
    }

    $reg = new Register();
    $reg->name = $request->name;
    $reg->email = $request->email;
    $reg->password = Hash::make($request->password);
    $reg->phone = $request->phone;
    $reg->dob = $request->dob;
    $reg->gender = $request->gender;
    $reg->address = $request->address;
    $reg->profile = $profilePath;

    $verificationToken = Str::random(60);
    $reg->status = $verificationToken;

    if ($reg->save()) {
        $verificationUrl = url('/verify-email/' . $verificationToken);
        Mail::to($reg->email)->send(new VerifyEmail($reg, $verificationUrl));
        return redirect('register')->with('success', 'Thank you for registration. Please check your email to verify your account.');
    }

    return redirect('/register')->with('error', 'Registration failed');
}

    public function verifyEmail($token)
    {
        $user = Register::where('status', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }

        $user->status = 'active';
        $user->save();

        return redirect('/login')->with('success', 'Email verified successfully. You can now log in.');
    }



    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);


        $user = Register::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            if ($user->status === 'active') {

                session(['user' => $user]);
                return redirect('index');
            } else {

                return redirect('login')->with('error', 'Your account is not activated. Please verify your email.');
            }
        } else {

            return redirect('login')->with('error', 'Invalid email or password.');
        }
    }






    public function logout()
    {
        session()->forget('user');
        return redirect('index');
    }

    public function showCart()
    {
        if (session('user')) {
          
            $id = session('user')->id;
            $cartItems = Cart::where('user_id', $id)->get();

            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id); 
                if ($product) {
                    $totalPrice += $product->price * $item->quantity;
                }
            }
        } else {
           
            $cartItems = session()->get('cart', []);

        
            $totalPrice = 0; 
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']); 
                if ($product) {
                    $totalPrice += $product->price * $item['quantity'];
                }
            }
        }
        $products = Product::whereIn('id', $cartItems->pluck('product_id'))->get();
     
        return view('cart', compact('products', 'totalPrice','cartItems'));
    }

    public function updateCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity');

        if (session('user')) {
          
            $cartItem = Cart::where('product_id', $productId)->where('user_id', session('user')->id)->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                return redirect()->back()->with('success', 'Cart updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Product not found in cart.');
            }
        } else {
       
            $cartItems = session()->get('cart', []);
            foreach ($cartItems as $key => &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $quantity;
                    session()->put('cart', $cartItems);
                    return redirect()->back()->with('success', 'Cart updated successfully.');
                }
            }
            return redirect()->back()->with('error', 'Product not found in cart.');
        }
    }

    public function show_checkout(Request $request)
    {
      
        $totalPrice = $request->query('total_price');
    
        return view('checkout', compact('totalPrice'));
    }
    

    public function process_checkout(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required', 
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'email' => 'required|email'
        ]);

       
        $cartItems = Cart::where('user_id', Register::where('email', session('user')->email)->first()->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/checkout')->with('error', 'No items in the cart to checkout.');
        }

       
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $totalAmount += $product->price * $item->quantity;
            }
        }

       
        $order = orders::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'], 
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'zip' => $validatedData['zip'],
            'total_amount' => $totalAmount,
            'status' => 'waiting'
        ]);

 
        Cart::where('user_id', Register::where('email', session('user')->email)->first()->id)->delete();

        return redirect('/checkout')->with('success', 'Order placed successfully! Your order status is waiting for confirmation.');
    }



    public function products_page()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function removeFromCart(Request $request, $productId)
    {
            $cartItem = Cart::where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Product removed from cart.');
            } else {
                return redirect()->back()->with('error', 'Product not found in cart.');
            }
    }
      
    
    public function addToCart(Request $request, $productId) {
        $product = Product::find($productId);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

  
        $cartItem = Cart::where('product_id', $productId)->first();

        if ($cartItem) {
           
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
        
            Cart::create([
                'product_id' => $productId,
                'quantity' => 1,
                'user_id' => Register::where('email', session('user')->email)->first()->id,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

     
        $products = Product::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();

        return view('product', compact('products'));
    }

    public function showProfile($id)
    {
        $user = Register::find($id);

        if (!$user) {
            return redirect('/')->with('error', 'User not found');
        }

        return view('profile', compact('user'));
    }
    public function edit($id)
    {
        $user = Register::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return view('profile_Edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'pro_pic' => 'image|mimes:jpeg,png,jpg,gif',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'string|max:10',
            'current_password' => 'required_with:password',
            'password' => 'nullable|string|min:6|confirmed',
            'address' => 'required|string',
        ]);

        $user = Register::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'The current password does not match']);
            }
        }

        $user->name = $request->name;
        $user->gender = $request->gender;

        if ($request->hasFile('pro_pic')) {
            $image = $request->file('pro_pic');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/profile'), $fileName);  

            if ($user->profile && file_exists(public_path('uploads/' . $user->profile))) {
                unlink(public_path('img/profile/' . $user->profile));
            }

            $user->profile = $fileName;
        }

        $user->email = $request->email;
        $user->phone = $request->phone_number;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('single_product', compact('product'));
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

  
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = register::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered.']);
        }

       
        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'email' => $request->email]);

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Password Reset OTP');
        });

        return redirect()->route('verify.otp.form');
    }
    public function resendOtp()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('forgot.password.form')
                ->withErrors(['email' => 'Email not found. Please start the password reset process again.']);
        }

        $otp = rand(100000, 999999);
        session(['otp' => $otp]);

        Mail::raw("Your new OTP is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('New Password Reset OTP');
        });

        return redirect()->route('verify.otp.form')
            ->with('success', 'A new OTP has been sent to your email.');
    }

  
    public function showOtpVerificationForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if ($request->otp != session('otp')) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        return redirect()->route('reset.password.form');
    }

  
    public function showResetPasswordForm()
    {
        return view('reset-password');
    }

    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = register::where('email', session('email'))->first();
        $user->password = bcrypt($request->password);
        $user->save();

        session()->forget(['otp', 'email']);

        return redirect()->route('login')->with('success', 'Password updated successfully. Please log in.');
    }

    public function showMembership()
    {
        $membershipPlans = MembershipPlan::all();
        return view('membership', compact('membershipPlans'));
    }



    public function showMembershipCheckout($id)
    {
        $membershipPlan = MembershipPlan::findOrFail($id);
        return view('membership_checkout', ['selectedPlan' => $membershipPlan]);
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'membership_id' => 'required|exists:membership_plans,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'card_number' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $membershipPlan = MembershipPlan::findOrFail($request->input('membership_id'));

        $paymentSuccessful = $this->processPayment($request->all(), $membershipPlan->price);

        if ($paymentSuccessful) {
           
            if (!session()->has('user')) {
                return redirect()->route('login')->with('error', 'Please log in to purchase a membership.');
            }

           
            $user = session('user');

        
            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found. Please log in again.');
            }

           
            $existingMembership = Memberships::where('user_id', $user->id)
                ->where('end_date', '>', now())
                ->first();

            if ($existingMembership) {
                return redirect()->back()->with('error', 'You already have an active membership. You cannot purchase another one at this time.');
            }

            $membership = new Memberships();
            $membership->user_id = $user->id;
            $membership->membership_plan_id = $membershipPlan->id;
            $membership->start_date = now();
            $membership->end_date = now()->addMonths(1);
            $membership->save();

      
            if (view()->exists('emails.membership_confirmation')) {
                Mail::send('emails.membership_confirmation', ['user' => $user, 'membershipPlan' => $membershipPlan, 'membership' => $membership], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Your Membership Purchase Confirmation');
                });
            } else {
              
                \Log::error('Membership confirmation email template not found');
                Mail::send('emails.membership_expiration', ['user' => $user, 'membershipPlan' => $membershipPlan, 'membership' => $membership], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Your Membership Purchase Confirmation');
                });
            }

          
            $reminderDate = $membership->end_date->subDay();

          
            if (class_exists('\App\Mail\ExpirationReminder')) {
                $expirationReminderMailable = new \App\Mail\ExpirationReminder($user, $membership);
                Mail::to($user->email)->later($reminderDate, $expirationReminderMailable);
            } else {
               
                Mail::send('emails.membership_expiration', ['user' => $user, 'membershipPlan' => $membershipPlan, 'membership' => $membership], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Your Membership is Expiring Soon');
                });
            }

            
            if (class_exists('\App\Mail\MembershipExpired')) {
                $membershipExpiredMailable = new \App\Mail\MembershipExpired($user, $membership);
                Mail::to($user->email)->later($membership->end_date, $membershipExpiredMailable);
            } else {
                
                Mail::send('emails.membership_expiration', ['user' => $user, 'membershipPlan' => $membershipPlan, 'membership' => $membership], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Your Membership Has Expired');
                });
            }

            if (\Illuminate\Support\Facades\Route::has('membership')) {
                return redirect()->route('membership')->with('success', 'Membership purchased successfully! An email has been sent regarding your membership details.');
            } else {
                
                return redirect()->route('home')->with('success', 'Membership purchased successfully! An email has been sent regarding your membership details.');
            }
        } else {
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }

    private function processPayment($data, $amount)
    {
       
        $paymentDetails = [
            'card_number' => $data['card_number'],
            'expiry_date' => $data['expiry_date'],
            'cvv' => $data['cvv'],
            'amount' => $amount,
        ];

       
        return true;
    }



}

