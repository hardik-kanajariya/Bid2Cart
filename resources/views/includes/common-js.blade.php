<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/vendors/js/vendor.bundle.base.js"></script>
<script src="{{ url('/') }}/vendors/chart.js/Chart.min.js"></script>
<script src="{{ url('/') }}/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/vendors/dropify/dropify.min.js"></script>
{{-- <script src="{{ url('/') }}/vendors/jquery-toast-plugin/jquery.toast.min.js"></script> --}}
<script src="{{ url('/') }}/js/off-canvas.js"></script>
<script src="{{ url('/') }}/js/hoverable-collapse.js"></script>
<script src="{{ url('/') }}/js/template.js"></script>
<script src="{{ url('/') }}/js/jquery.cookie.js" type="text/javascript"></script>
<script src="{{ url('/') }}/js/dashboard.js"></script>
<script src="{{ url('/') }}/js/data-table.js"></script>
<script src="{{ url('/') }}/js/dropify.js"></script>

<script>
(function($) {
  showSuccessToast = function(msg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Success',
      text: msg,
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };
  showInfoToast = function(msg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Info',
      text: msg,
      showHideTransition: 'slide',
      icon: 'info',
      loaderBg: '#46c35f',
      position: 'top-right'
    })
  };
  showWarningToast = function(msg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Warning',
      text: msg,
      showHideTransition: 'slide',
      icon: 'warning',
      loaderBg: '#57c7d4',
      position: 'top-right'
    })
  };
  showDangerToast = function(msg) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Danger',
      text: msg,
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    })
  };
  showToastPosition = function(position) {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Positioning',
      text: 'Specify the custom position object or use one of the predefined ones',
      position: String(position),
      icon: 'info',
      stack: false,
      loaderBg: '#f96868'
    })
  }
  showToastInCustomPosition = function() {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'Custom positioning',
      text: 'Specify the custom position object or use one of the predefined ones',
      icon: 'info',
      position: {
        left: 120,
        top: 120
      },
      stack: false,
      loaderBg: '#f96868'
    })
  }
  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }
})(jQuery);
</script>