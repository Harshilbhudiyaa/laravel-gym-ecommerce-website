<?php

namespace App\Http\Controllers;
use App\Models\aboutus;
use App\Models\contact;
use App\Models\membership_plans;
use App\Models\trainer;
use App\Models\service;
use App\Models\slider;
use App\Models\register;
use App\Models\memberships;
use App\Models\admin_data;
use App\Models\MembershipPlan;
use App\Models\product;
use App\Models\orders;
use App\Models\categories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Mail;

use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class admin extends Controller
{
    public function a_login()
    {
        return view('admin_a_login');
    }

    public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $admin = admin_data::where('email', $request->email)->first();
    
        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_email', $admin->email);
            return redirect()->route('admin_home');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }
    }

    public function logout()
    {
        Session::forget('admin_email');
        return redirect()->route('log');
    }

    public function home1() {
        return view ('admin_home');
    }

    public function About1() {
        $aboutUsData = aboutus::all();
        return view('admin_About', compact('aboutUsData'));
    }

    public function storeAbout(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalImageName = $image->getClientOriginalName();
            $image->move(public_path('img/about'), $originalImageName);
        }

        $aboutUs = new aboutus();
        $aboutUs->img = $originalImageName;
        $aboutUs->description = $request->input('description');
        $aboutUs->save();

        return redirect()->back()->with('success', 'About Us information saved successfully.');
    }

    public function updateAbout(Request $request, $id) {
        $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
    
        $aboutUs = aboutus::findOrFail($id);
        $aboutUs->description = $request->input('description');
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalImageName = $image->getClientOriginalName();
            $image->move(public_path('img/about'), $originalImageName);
            $aboutUs->img = $originalImageName;
        }
    
        $aboutUs->save();
    
        return redirect()->back()->with('success', 'About Us information updated successfully.');
    }
    
    public function deleteAbout($id) {
        $aboutUs = aboutus::findOrFail($id);
    
        if ($aboutUs->img) {
            $imagePath = public_path('img/about/' . $aboutUs->img);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        $aboutUs->delete();
    
        return redirect()->back()->with('success', 'About Us information deleted successfully.');
    }

    public function showMembershipForm()
    {
        $data = MembershipPlan::all();
        return view('membership_form',compact('data'));
    }

    public function storeMembership(Request $request)
    {
        $validatedData = $request->validate([
            'membership_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'required|array',
        ]);

        $membership = new MembershipPlan();
        $membership->membership_type = $validatedData['membership_type'];
        $membership->price = $validatedData['price'];
        $membership->features = json_encode($validatedData['features']);
        $membership->save();

        return redirect()->route('membership.form')->with('success', 'Membership plan added successfully!');
    }

    public function editMembership($id)
    {
        $membership = MembershipPlan::findOrFail($id);
        $data = MembershipPlan::all();
        return view('membership_form', compact('membership', 'data'));
    }

    public function updateMembership(Request $request, $id)
    {
        $membership = MembershipPlan::findOrFail($id);

        $validatedData = $request->validate([
            'membership_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'required|array',
        ]);

        $membership->membership_type = $validatedData['membership_type'];
        $membership->price = $validatedData['price'];
        $membership->features = json_encode($validatedData['features']);
        $membership->save();

        return redirect()->route('membership.form')->with('success', 'Membership plan updated successfully!');
    }

    public function destroyMembership($id)
    {
        $membership = MembershipPlan::findOrFail($id);
        $membership->delete();

        return redirect()->route('membership.form')->with('success', 'Membership plan deleted successfully!');
    }

    public function handleProductSubmission(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:4',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|max:1000',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id', 
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/products'), $imageName);
        }
        $categoryName = categories::where('id', $validatedData['category_id'])->value('category');

        $product = new Product();
        $product->name = $validatedData['name'];
        $product->image = $imageName;
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->discounted = $validatedData['price'];
        $product->categories = $categoryName; 
        $product->save();

        return redirect()->route('products.show')->with('success', 'Product added successfully!');
    }

    public function products1()
    {
        $products = Product::all();
        $categories = categories::all();
        return view('admin_products', compact('products','categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category' => 'sometimes|string', 
        ]);
    
        if ($request->has('name')) {
            $product->name = $validatedData['name'];
        }
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('img/products/' . $product->image))) {
                unlink(public_path('img/products/' . $product->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img/products'), $imageName);
            $product->image = $imageName;
        }
        if ($request->has('description')) {
            $product->description = $validatedData['description'];
        }
        if ($request->has('price')) {
            $product->price = $validatedData['price'];
            $product->discounted = $validatedData['price'];
        }
        if ($request->has('category')) {
            $product->categories = $validatedData['category']; 
        }
    
        $product->save();
    
        return redirect()->route('products.show')->with('success', 'Product updated successfully.');
    }

    public function destroy_product($id)
    {
        $product = Product::findOrFail($id);

        $imagePath = public_path('img/products/' . $product->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();

        return redirect()->route('products.show')->with('success', 'Product deleted successfully.');
    }

    public function trainer1(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'name' => 'required|min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
    
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/trainer'), $imageName);
    
            trainer::create([
                'name' => $request->name,
                'image' => $imageName,
            ]);
    
            return redirect()->back()->with('success', 'Trainer added successfully!');
        }
    
        $trainers = trainer::all();
        return view('admin_trainer', compact('trainers'));
    }

    public function updateTrainer(Request $request, $id)
    {
        $trainer = Trainer::find($id);
        if (!$trainer) {
            return redirect()->back()->with('error', 'Trainer not found!');
        }
    
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $trainer->name = $request->input('name');
    
        if ($request->hasFile('image')) {
            $oldImage = public_path('img/trainer/' . $trainer->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
    
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img/trainer'), $imageName);
            $trainer->image = $imageName;
        }
    
        $trainer->save();
    
        return redirect()->back()->with('success', 'Trainer updated successfully!');
    }
    
    public function deleteTrainer($id)
    {
        $trainer = Trainer::find($id);
        
        if (!$trainer) {
            return redirect()->back()->with('error', 'Trainer not found!');
        }

        $imagePath = public_path('img/trainer/' . $trainer->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $trainer->delete();

        return redirect()->back()->with('success', 'Trainer deleted successfully!');
    }

    public function user1()
    {
        $users = register::all();
        return view('admin_user', compact('users'));
    }

   public function storeUser(Request $request)
   {
      
    $request->validate([
        'name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z\s.]+$/',
        'email' => 'required|email|unique:register,email',
        'phone' => 'required|string|max:20',
        'password' => 'required',
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
    $reg->status = 'Active';
    $reg->address = $request->address;
    $reg->profile = $profilePath;


    if ($reg->save()) {
        
        return redirect()->back()->with('success', 'User registered successfully!');
    }

    
       return redirect()->back()->with('error', 'registertion failed  ');
   }
   


    public function user_update(Request $request, $id)
    {
        $user = register::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->status = $request->status;

        if ($request->hasFile('profile_pic')) {
            $imageName = time() . '.' . $request->profile_pic->extension();
            $request->profile_pic->move(public_path('img/profile'), $imageName);
            $user->profile = $imageName;
        }

        $user->save();

        return redirect('/admin_user')->with('success', 'User updated successfully.');
    }

    public function user_delete($id)
    {
        $user = register::find($id);
        $user->delete();
        return redirect('/admin_user')->with('success', 'User deleted successfully.');
    }

    public function testomonial1() {
        return view ('admin_Testomonial');
    }

   
    public function service1()
    {
        $services = service::all();
        return view('admin_service', compact('services'));
    }

    public function store_service(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('img/service'), $imageName);

        service::create([
            'title' => $request->title,
            'description' => $request->description,
            'img' => $imageName,
        ]);

        return redirect()->route('service.index')->with('success', 'Service created successfully.');
    }

    public function service_update(Request $request, $id)
    {
        $service = service::find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $service->title = $request->title;
        $service->description = $request->description;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/service'), $imageName);
            $service->img = $imageName;
        }

        $service->save();

        return redirect()->route('service.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = service::find($id);
        $service->delete();
        return redirect()->route('service.index')->with('success', 'Service deleted successfully.');
    }

    public function admin_prof1() {
        $email = session('admin_email');
        $admin = admin_data::where('email', $email)->first();
        return view('admin_profile', ['admin' => $admin]);
    }

    public function edit_admin1()
    {
        $email = session('admin_email');
        $admin = admin_data::where('email', $email)->first();
        return view('edit_admin_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = admin_data::where('email', session('admin_email'))->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admin_data', 'email')->ignore($admin->id),
            ],
            'old_password' => 'nullable',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'same:new_password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $admin->name = $request->name;

        if ($request->email !== $admin->email) {
            $admin->email = $request->email;
            session(['admin_email' => $request->email]);
        }

        if ($request->hasFile('profile_picture')) {
            if ($admin->profile) {
                $oldFile = public_path('img/admin_profiles/' . $admin->profile);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $fileName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('img/admin_profiles'), $fileName);
            $admin->profile = $fileName;

            session(['profile_picture' => $fileName]);
        }

        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $admin->password)) {
                $admin->password = bcrypt($request->new_password);
            } else {
                return redirect()->back()->withErrors(['old_password' => 'The old password does not match our records.']);
            }
        }

        $admin->save();
        session(['admin_name' => $admin->name]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function destroy_admin($id)
    {
        $admin = admin_data::findOrFail($id);

        if ($admin->profile) {
            $filePath = public_path('img/admin_profiles/' . $admin->profile);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Admin deleted successfully!');
    }

    public function slider1()
    {
        $sliders = Slider::all();
        return view('admin_slider', compact('sliders'));
    }

    public function sliderStore1(Request $request)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'productPrice' => 'required|numeric|min:0',
        ]);

        $imageName = time().'.'.$request->productImage->extension();
        $request->productImage->move(public_path('img/slider'), $imageName);

        $slider = new Slider();
        $slider->name = $request->productName;
        $slider->image = $imageName;
        $slider->Price = $request->productPrice;
        $slider->save();

        return redirect()->back()->with('success', 'Slider added successfully!');
    }

    public function sliderUpdate(Request $request, $id)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'productPrice' => 'required|numeric|min:0',
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('productImage')) {
            if (file_exists(public_path('img/slider/' . $slider->image))) {
                unlink(public_path('img/slider/' . $slider->image));
            }

            $imageName = time().'.'.$request->productImage->extension();
            $request->productImage->move(public_path('img/slider'), $imageName);
            $slider->image = $imageName;
        }

        $slider->name = $request->productName;
        $slider->Price = $request->productPrice;
        $slider->save();

        return redirect()->route('slider1')->with('success', 'Slider updated successfully!');
    }

    public function sliderDelete($id)
    {
        $slider = Slider::findOrFail($id);

        if (file_exists(public_path('img/slider/' . $slider->image))) {
            unlink(public_path('img/slider/' . $slider->image));
        }

        $slider->delete();

        return redirect()->back()->with('success', 'Slider deleted successfully!');
    }

    

    
    public function index()
    {
        $messages = contact::all();
        return view('admin_message', compact('messages'));
    }

    public function new_admin()
    {
        $admins = admin_data::all();
        return view('add_admin', ['admins' => $admins]);
    }

    public function store_admin(Request $request)   
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_data,email',
            'profile' => 'required|image|mimes:jpg,png,jpeg,gif',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $profileImageName = null;
        if ($request->hasFile('profile')) {
            $profileImage = $request->file('profile');
            $profileImageName = time() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->move(public_path('img/admin_profiles'), $profileImageName);
        }

        admin_data::create([
            'name' => $request->name,
            'email' => $request->email,
            'profile' => $profileImageName,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/admin_add_new')->with('success', 'Admin added successfully.');
    }

    public function membershipUsers()
    {
        $allUsers = \App\Models\Register::with(['memberships.membershipPlan'])->get();
        
        $allUsers = $allUsers->map(function ($user) {
            $user->memberships = $user->memberships->filter(function ($membership) {
                return $membership->end_date >= now();
            });
            return $user;
        });

        $allUsers = $allUsers->sortBy([
            fn ($a, $b) => $b->memberships->count() <=> $a->memberships->count(),
            fn ($a, $b) => $b->memberships->max('end_date') <=> $a->memberships->max('end_date')
        ]);

        return view('membership_user', compact('allUsers'));
    }


    public function setting1(){
        $categories = categories::all(); 

        return view('admin_setting',compact('categories'));
    }


    public function applyOffer(Request $request)
    {
       
        $request->validate([
            'offerPercentage' => 'required|integer|min:0|max:100',
            'category' => 'required|string|exists:categories,category',
        ]);
    
        $offerPercentage = $request->input('offerPercentage');
        $categoryName = $request->input('category');
    
     
        $products = Product::where('categories', $categoryName)->get();
    
        foreach ($products as $product) {
            if ($offerPercentage == 0) {
               
                $discounted = $product->price;
            } else {
              
                $discounted = $product->price * (1 - ($offerPercentage / 100.0));
            }
    
          
            $product->discounted = max($discounted, 0);
    
            $product->save();
        }
    
        return redirect()->back()->with('success', 'Offer applied successfully to selected category!');
    }





    public function admin_category()
    {
   
        $categories = categories::all();


        return view('admin_category', compact('categories'));
    }

  
    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,category',
        ]);

        categories::create([
            'category' => $request->name,  
        ]);

      
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function destroy_category($id)
    {
       
        $category = categories::findOrFail($id);
        $category->delete();

        
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }




    public function orders1(Request $request) {
        $orders = orders::all();
        return view('admin_orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request)
    {
       
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:waiting,canceled,confirmed,delivered',
        ]);
    
     
        $order = orders::find($request->order_id);
    
        if ($order) {
           
            if ($request->status == 'canceled') {
               
                $email = $order->email;
                $message = "Dear {$order->name},\n\nYour order (Order ID: {$order->id}) has been canceled.\n\nIf you have any questions, please contact support.\n\nThank you.";
                Mail::raw($message, function ($mail) use ($email) {
                    $mail->to($email)
                         ->subject('Order Cancellation Notification');
                });
    
              
                $order->delete();
    
                return redirect()->back()->with('success', 'Order canceled and email sent to the user.');
            }
           
        if ($request->status == 'confirmed') {
           
            $email = $order->email;
            $message = "Dear {$order->name},\n\nYour order (Order ID: {$order->id}) has been confirmed and will be delivered soon.\n\nThank you for shopping with us!";
            Mail::raw($message, function ($mail) use ($email) {
                $mail->to($email)
                     ->subject('Order Confirmation Notification');
            });

          
            $order->status = 'confirmed';
            $order->save();

            return redirect()->back()->with('success', 'Order confirmed and email sent to the user.');
        }

        if ($request->status == 'delivered') {
            
            $email = $order->email;
            $message = "Dear {$order->name},\n\nYour order (Order ID: {$order->id}) has been delivered successfully. We hope you enjoy your purchase!\n\nThank you for shopping with us!";
            Mail::raw($message, function ($mail) use ($email) {
                $mail->to($email)
                     ->subject('Order Delivered Notification');
            });

            $order->delete();

            return redirect()->back()->with('success', 'Order delivered, email sent to the user, and order removed from the database.');
        }

            $order->status = $request->status;
            $order->save();
    
            return redirect()->back()->with('success', 'Order status updated successfully.');
        }
    
        return redirect()->back()->with('error', 'Order not found.');
    }


public function reply(Request $request, $id)
{
    $request->validate([
        'replyMessage' => 'required|string',
    ]);

    $message = contact::findOrFail($id);
    $email = $message->email;
    $replyMessage = $request->input('replyMessage');

    Mail::raw($replyMessage, function ($mail) use ($email) {
        $mail->to($email)
             ->subject('Reply to Your Message');
    });

  
    $message->delete();

    return redirect()->back()->with('success', 'Reply sent successfully and message deleted.');
}
}
