<!-- Ensure Bootstrap JS is loaded -->

<!-- Подключение DataTables -->
<script type="text/javascript" src="bootstrap/assets/js/jquery.dataTables.min.js"></script>
<script src="bootstrap/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/assets/js/sidebarmenu.js"></script>
<script src="bootstrap/assets/js/app.min.js"></script>
<script src="bootstrap/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="bootstrap/assets/libs/simplebar/dist/simplebar.js"></script>
<script src="bootstrap/assets/js/dashboard.js"></script>
<script src="js/global.js"></script>

<script type="text/javascript">
    //обработчик
    jQuery(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();

    });
    //активный класс
    $(function(){
        $("#demo-list li").click(function(){
            $("#demo-list li.active").removeClass("active")
            $(this).addClass("active");
        })
    })
</script>

<script type="text/javascript">
    //поисковая строка
    (function($) {
        $.expr[":"].Contains = function(a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        function filterList(header, list) {
            var form = $("<form>").attr({
                "class":"filterform",
                action:"#"
            }), input = $("<input>").attr({
                "class":"filterinput",
                type:"text"
            });
            $(form).append(input).appendTo(header);
            $(input).change(function() {
                var filter = $(this).val();
                if (filter) {
                    $matches = $(list).find("a:Contains(" + filter + ")").parent();
                    $("li", list).not($matches).slideUp();
                    $matches.slideDown();
                } else {
                    $(list).find("li").slideDown();
                }
                return false;
            }).keyup(function() {
                $(this).change();
            });
        }
        $(function() {
            filterList($("#form"), $("#demo-list"));
        });
    })(jQuery);
</script>
<script src="js/vam.md.js"></script>


