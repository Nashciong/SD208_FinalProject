<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>;
<script type="text/javascript">
    $(document).ready(function() {
        $("#search").keyup(function() {
            var input = $(this).val();
            // alert(input);
            if (input != "") {
                jQuery.ajax({
                    url: "livesearch.php",
                    method: "POST",
                    data: {
                        input: input,
                    },
                    success: function(data) {
                        if (input == "today") {
                            $("#now-empty").html(data);
                            $("#now-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        } else if (input == "overdue") {
                            $("#overdue-empty").html(data);
                            $("#overdue-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        } else if (input == "upcoming") {
                            $("#upcoming-empty").html(data);
                            $("#upcoming-empty").css({
                                "display": " block",
                                "background": " #D0F3A5"
                            });
                        } else {

                        }
                    }
                });
            } else {
                $("#now-empty,#overdue-empty,#upcoming-empty").fadeOut(5000).css("display","none");
            }
        });
        $(".todo").on('click', function() {
            var td = "today";
            if (td == "today") {
                jQuery.ajax({
                    url: "displayQueryToday.php",
                    method: "POST",
                    data: {
                        today: td,
                    },
                    success: function(data) {
                        $(".now-empty").fadeIn(1000).html(data);
                        $(".now-empty").css({
                            "display": " block",
                            "background": " #D0F3A5"
                        });
                    }

                })
            }
        });
        $(".todo").on('click', function() {
            var od = "overdue";
            if (od == "overdue") {
                jQuery.ajax({
                    url: "displayQueryOverdue.php",
                    method: "POST",
                    data: {
                        overdue: od,
                    },
                    success: function(data) {
                        $(".overdue-empty").fadeIn(3000).html(data);
                        $(".overdue-empty").css({
                            "display": " block",
                            "background": " #D0F3A5"
                        });
                    }

                })
            }
        });
        $(".todo").on('click', function() {
            var uc = "upcoming";
            if (uc == "upcoming") {
                jQuery.ajax({
                    url: "displayQueryUpcoming.php",
                    method: "POST",
                    data: {
                        upcoming: uc,
                    },
                    success: function(data) {
                        $(".upcoming-empty").fadeIn(5000).html(data);
                        $(".upcoming-empty").css({
                            "display": " block",
                            "background": " #D0F3A5"
                        });
                    }

                })
            }
        });
    });
</script>