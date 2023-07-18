<script>
    $(function() {
        $('#interval').daterangepicker({
            timePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('#interval').on('change', function() {
            assignStartEnd();
        });

        // Assign First and Last Date
        function assignStartEnd() {
            var start_date = formattedDay(new Date($('#interval').data('daterangepicker').startDate));
            var end_date = formattedDay(new Date($('#interval').data('daterangepicker').endDate));
            $('#start_date').val(start_date);
            $('#end_date').val(end_date);
        }

        // Date Time with Format
        function formattedDay(date) {
            var dd = String(date.getDate()).padStart(2, '0');
            var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = date.getFullYear();
            var h = String(date.getHours());
            var m = String(date.getMinutes());

            date = yyyy + '/' + mm + '/' + dd + ' ' + h + ':' + m;
            return date;
        }
    });
</script>
