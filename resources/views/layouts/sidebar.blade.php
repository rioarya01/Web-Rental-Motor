 <style>
     .sidebar .nav-item .nav-content i {
         font-size: 15px;
     }

     .nav.nav-link {
         background: #f1f1f1;
         color: #4f46e5;
         border-radius: 8px;
         margin-bottom: 10px;
         padding: 12px 16px;
         transition: 0.3s;
     }

     .nav.nav-link.active {
         background: #4f46e5;
         color: white;
     }

     .nav.nav-link.active i {
         color: white;
     }
 </style>
 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav nav-link {{ request()->routeIs('home.admin') ? 'active' : '' }}"
                 href="{{ route('home.admin') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav nav-link {{ request()->routeIs('vehicles-data') ? 'active' : '' }}"
                 href="{{ route('vehicles-data') }}">
                 <i class="bi bi-gear"></i><span>Kendaraan</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}"
                 href="{{ route('customers.index') }}">
                 <i class="bi bi-people"></i><span>Customers</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav nav-link {{ request()->routeIs('booking.index') ? 'active' : '' }}"
                 href="{{ route('booking.index') }}">
                 <i class="bi bi-card-checklist"></i><span>Data Konfirmasi Booking</span>
             </a>
         </li>
     </ul>

 </aside><!-- End Sidebar-->
