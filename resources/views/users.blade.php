<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bid2Cart  Admin Panel</title>
  <!-- Common Head Files -->
  @include('includes.common-css')
</head>
<body>
  <div class="container-scroller"> 
    <!-- partial:partials/_navbar.html -->
   @include('includes.navbar')
    <div class="container-fluid page-body-wrapper">
      <!-- sidebar -->
    @include('includes.sidebar')
      <!-- Content Goes Here -->
      <div class="main-panel">
        <div class="content-wrapper">
          {{-- Body Content Starts --}}
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr>
                        <th>#User Id</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td>{{ $user->userid }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if ($user->status == 'pending')
                            <label class="badge badge-warning">Pending</label>
                          @elseif ($user->status == 'declined')
                            <label class="badge badge-danger">Deactivated</label>  
                          @elseif ($user->status == 'active')
                            <label class="badge badge-success">Active</label>  
                          @endif
                        </td>
                        <td>
                          <a href="{{ url('/') }}/users/{{ $user->userid }}/{{ $user->first_name }}" class="btn btn-outline-primary btn-sm rounded-0 p-3">View</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          {{-- Body Content Ends Here --}}
        </div>

        <!-- content-wrapper ends -->
        @include('includes.footer')
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
  <!-- Common JS Files -->
  @include('includes.common-js')
  <script src="{{ url('/') }}/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="{{ url('/') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="{{ url('/') }}/vendors/dropify/dropify.min.js"></script>
  <script src="{{ url('/') }}/js/dropify.js"></script>
</body>

</html>

