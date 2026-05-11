 <style>
     .sidebar .nav-item .nav-content i {
         font-size: 15px;
     }
 </style>
 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link" href="{{ route('home.admin') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-database-add"></i><span>Data</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('vehicles-data') }}">
                         <i class="bi bi-gear"></i><span>Kendaraan</span>
                     </a>
                 </li>

             </ul>
         </li><!-- End Components Nav -->

     </ul>

 </aside><!-- End Sidebar-->
