<script type="text/javascript">
    "use strict";

    $(function() {
        
        $('.tagify:not(.inited)').each(function(index, element) {
            var tagify = new Tagify(element, {
                placeholder: '{{ get_phrase('Enter your keywords') }}'
            });
            $(element).addClass('inited');
        });

    });
</script>
