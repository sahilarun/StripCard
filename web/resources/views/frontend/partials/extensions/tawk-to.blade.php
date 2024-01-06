@if (count($__extensions) > 0)
    @php
        $tawk_to        = $__extensions->where("slug",extension_const()::TAWK_TO_SLUG)->first();
        $property_id    = extension_const()::TAWK_TO_PROPERTY_ID;
        $widget_id      = extension_const()::TAWK_TO_WIDGET_ID;
    @endphp

    @if ($tawk_to && isset($tawk_to->shortcode->$property_id->value) && isset($tawk_to->shortcode->$widget_id->value) && $tawk_to->status == true)
        <script type="text/javascript">
            var property    = "{{ $tawk_to->shortcode->$property_id->value }}";
            var widget      = "{{ $tawk_to->shortcode->$widget_id->value }}";

            if(property.length > 0 && widget.length > 0) {
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src=`https://embed.tawk.to/${property}/${widget}`;
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
                })();
            }
        </script>
    @endif
@endif