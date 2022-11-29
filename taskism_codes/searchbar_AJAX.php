<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>;
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var input = $(this).val();
                // alert(input);
                if (input != "") {
                    $.ajax({
                        url: "livesearch.php",
                        method: "POST",
                        data: {
                            input: input,
                        },
                        success: function(data) {
                            if (input == "today") {
                                $("#now-empty").html(data);
                                $("#now-empty").css("display",
                                    " block");
                                $("#now-empty").css("background", " #D0F3A5");
                            } else {
                                $("#now-empty").show("#now-empty");
                            }
                            if (input == "overdue") {
                                $("#overdue-empty").html(data);
                                $("#overdue-empty").css("display",
                                    " block");
                                $("#overdue-empty").css("background", " #D0F3A5");
                            } else {
                                $("#overdue-empty").show("#overdue-empty");
                            }
                            if (input == "upcoming") {
                                $("#upcoming-empty").html(data);
                                $("#upcoming-empty").css("display",
                                    " block");
                                $("#upcoming-empty").css("background", " #D0F3A5");
                            } else {
                                $("#upcoming-empty").show("#upcoming-empty");
                            }
                        }
                    });
                } else {
                    $("#now-empty,#overdue-empty,#upcoming-empty").css("display", "none");
                }
            });
        });
    </script>