<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Fitness Gym</title>
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/styles.css">
    <link rel="icon" href="{{ URL::to('/') }}/icons/men (1).png">
    <!-- Boxicons CDN Link -->
    <link href='{{URL::to('/')}}/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ URL::to('/') }}/css/bootstrap_admin.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      #prof{
        background-color: #1d1b31;
        color: white;
            }
    </style>
   </head>
<body>  
  <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx icon'><img src="{{ URL::to('/') }}/icons/men (1).png" alt="" style="margin-left:65px"></i> -->
        <div class="logo_name">Fitness </div> 
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      {{-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> --}}
      <li>
        <a href="{{ URL::to('/') }}/admin_home">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
         <span class="tooltip">Dashboard</span>
      </li>
      <li>
       <a href="{{ URL::to('/') }}/admin_user">
         <i class='bx bx-user' ></i>
         <span class="links_name">User</span>
       </a>
       <span class="tooltip">User</span>
     </li>
     <li>
       <a href="{{ URL::to('/') }}/admin_message">
         <i class='bx bx-chat' ></i>
         <span class="links_name">Messages</span>
       </a>
       <span class="tooltip">Messages</span>
     </li>

     <li>
       <a href="{{ URL::to('/') }}/admin_membership_users">
         <i class='bx bx-group'></i>
         <span class="links_name">Membership Users</span>
       </a>
       <span class="tooltip">Membership Users</span>
     </li>
     
     <li>
       <a href="{{ URL::to('/') }}/admin_products">
         <i class='bx bx-box' ></i>
         <span class="links_name">Products</span>
       </a>
       <span class="tooltip">Products</span>
     </li>
     <!-- <li>
      <a href="{{ URL::to('/') }}/admin_testomonial">
          <i class='bx bxs-quote-alt-left'></i>
          <span class="links_name">Testimonial</span>
      </a>
      <span class="tooltip">Testimonial</span>
  </li>
   -->
     <li>
       <a href="{{ URL::to('/') }}/admin_orders">
         <i class='bx bx-cart-alt' ></i>
         <span class="links_name">Order</span>
       </a>
       <span class="tooltip">Order</span>
     </li>
     {{-- <li>
       <a href="#">
         <i class='bx bx-heart' ></i>
         <span class="links_name">Saved</span>
       </a>
       <span class="tooltip">Saved</span>
     </li> --}}
     <li>
    <a href="{{ URL::to('/') }}/admin_membership">
        <i class='bx bx-id-card'></i>
        <span class="links_name">Membership</span>
    </a>
    <span class="tooltip">Membership</span>
</li>
     <li>
       <a href="{{ URL::to('/') }}/admin_setting">
         <i class='bx bx-cog' ></i>
         <span class="links_name">Setting</span>
       </a>
       <span class="tooltip">Setting</span>
     </li>
     <li class="profile">
      
      <div class="profile-details">
        {{-- <img src="{{ URL::to('/') }}/img/testimonials/person3.jpg" alt="profileImg"> --}}
        <i class='bx bxs-lg bxs-user-circle bx-tada-hover'></i>
        <div class="name_job">
            <a href="{{ URL::to('/') }}/admin_profile" id="prof">
                <div class="name">Admin Profile</div>
            </a>  
            {{-- <div class="job">Admin</div>  --}}
        </div>
    </div>
    
    
    <!-- Logout Form -->
    <form action="{{ route('admin_logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class='bx bx-log-out' id="log_out"></i>
        </button>
    </form>
      
    </ul>
  </div>
  <section class="home-section">
    
      @yield('sidebar')

  </section>


  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  
  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange(); // Calling the function (optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
    sidebar.classList.toggle("open");
    menuBtnChange(); // Calling the function (optional)
  });

  // Following are the code to change sidebar button (optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); // Replacing the icons class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu"); // Replacing the icons class
   }
  }

  </script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
  