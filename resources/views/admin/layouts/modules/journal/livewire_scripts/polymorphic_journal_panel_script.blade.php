  <script>
      Livewire.on('print_journal', function() {
          $('#journal').printThis();
      });
      Livewire.on('download_journal', function() {
          html2canvas(document.querySelector('#journal')).then(function(canvas) {
              var anchorTag = document.createElement("a");
              document.body.appendChild(anchorTag);
              anchorTag.download = "receipt.jpg";
              anchorTag.href = canvas.toDataURL();
              anchorTag.target = '_blank';
              anchorTag.click();
          });
      });
      Livewire.on('polymorphic_journal_panel_success', message => {
          var notify_allow_dismiss = Boolean(
              {{ config('adminetic.notify_allow_dismiss', true) }});
          var notify_delay = {{ config('adminetic.notify_delay', 2000) }};
          var notify_showProgressbar = Boolean(
              {{ config('adminetic.notify_showProgressbar', true) }});
          var notify_timer = {{ config('adminetic.notify_timer', 300) }};
          var notify_newest_on_top = Boolean(
              {{ config('adminetic.notify_newest_on_top', true) }});
          var notify_mouse_over = Boolean(
              {{ config('adminetic.notify_mouse_over', true) }});
          var notify_spacing = {{ config('adminetic.notify_spacing', 1) }};
          var notify_notify_animate_in =
              "{{ config('adminetic.notify_animate_in', 'animated fadeInDown') }}";
          var notify_notify_animate_out =
              "{{ config('adminetic.notify_animate_out', 'animated fadeOutUp') }}";
          var notify = $.notify({
              title: "<i class='{{ config('adminetic.notify_icon', 'fa fa-bell-o') }}'></i> " +
                  "Alert",
              message: message
          }, {
              type: 'success',
              allow_dismiss: notify_allow_dismiss,
              delay: notify_delay,
              showProgressbar: notify_showProgressbar,
              timer: notify_timer,
              newest_on_top: notify_newest_on_top,
              mouse_over: notify_mouse_over,
              spacing: notify_spacing,
              animate: {
                  enter: notify_notify_animate_in,
                  exit: notify_notify_animate_out
              }
          });
      });
  </script>
