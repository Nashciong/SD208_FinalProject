<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>;

<script type="text/javascript">
    $(document).ready(function() {
        $("#search").keyup(function(event) {

            if (input != "") {
                var input = $(this).val();

                var d = new Date();

                var month = d.getMonth() + 1;
                var day = d.getDate();

                var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;

                if (input == "today") {
                    jQuery.ajax({
                        url: "displayQueryToday.php",
                        method: "POST",
                        data: {
                            today: output,
                        },
                        success: function(data) {
                            $("#now-empty").html(data);
                            $("#now-empty").css({
                                "display": " block",
                            });
                            $("#overdue,#upcoming").css("display", "none");
                        }
                    });
                }else if(input == "overdue"){
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
                            });
                            $("#now,#upcoming").css("display", "none");
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
                            });
                            $("#now,#overdue").css("display", "none");
                        }
                    });
                }
                else{
                    $("#now,#overdue,#upcoming").css("display", "block");
                }
            }else{
                $("#now,#overdue,#upcoming").css("display", "block");
            }
        })
        
    });
</script>

