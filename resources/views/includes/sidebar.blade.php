<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <!-- Categories -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}/category">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Categories</span>
        </a>
      </li>

      <!-- Auctions -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">Auctions</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/auctions/products"> Products </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/auctions/add/product"> Add New Product </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('view-auction-schedule') }}"> Auction </a></li>
            {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('schedule-new-auction') }}">Add New schedule</a></li> --}}
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/auctions/brands">Brands</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/auctions/stores">Stores</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/auctions/invoice-ads">Ads</a></li>
          </ul>
        </div>
      </li>
      <!-- Requests  -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#request" aria-expanded="false" aria-controls="request">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">Requests</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="request">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/request/pickup"> Pickup Requests</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/request/contact"> Contact </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/request/supports"> Support Questions</a></li>
          </ul>
        </div>
      </li>

      {{-- Invoices --}}
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#invoice" aria-expanded="false" aria-controls="invoice">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">Reports</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="invoice">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/invoice/all">User Invoice</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/invoice/companies">Brand Invoice</a></li>
            {{-- <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}/reports/">Bot Invoice</a></li> --}}
          </ul>
        </div>
      </li>

      <!-- Users -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}/users">
          <i class="icon-user-follow menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>
      <!-- Settings -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}/settings">
          <i class="icon-cog menu-icon"></i>
          <span class="menu-title">Settings</span>
        </a>
      </li>
    </ul>
  </nav>
