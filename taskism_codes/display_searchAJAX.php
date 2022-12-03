<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>;
<script type="text/javascript">
    $(document).ready(function() {
        $("#search").keyup(function() {
            var input = $(this).val();

            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day;

            if (input != "") {
                if (input == "today") {
                    jQuery.ajax({
                        url: "displayQueryToday.php",
                        method: "POST",
                        data: {
                            // 'input': input,
                            'today': output,
                        },
                        success: function(data) {
                            $("#now-empty").html(data);
                            $("#now-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        }
                    });
                } else if (input == "overdue") {
                    jQuery.ajax({
                        url: "displayQueryOverdue.php",
                        method: "POST",
                        data: {
                            // 'input': input,
                            'overdue': output,
                        },
                        success: function(data) {
                            $("#overdue-empty").html(data);
                            $("#overdue-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        }
                    });
                } else if (input == "upcoming") {
                    jQuery.ajax({
                        url: "displayQueryUpcoming.php",
                        method: "POST",
                        data: {
                            // 'input': input,
                            'upcoming': output,
                        },
                        success: function(data) {
                            $("#upcoming-empty").html(data);
                            $("#upcoming-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        }
                    });
                }

            } else {
                $("#now-empty,#overdue-empty,#upcoming-empty").css("display", "none");
            }
        });
    });
</script>