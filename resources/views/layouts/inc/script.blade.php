<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "metal": "#c4c5d6",
                "light": "#ffffff",
                "accent": "#00c5dc",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995",
                "focus": "#9816f4"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>
<script src="{{ asset('mix/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        // Global function to format numbers in European style (1.000.000,00)
        window.formatNumber = function(num) {
            // Remove periods for thousands and commas for decimals before parsing
            var number = parseFloat(num.replace(/\./g, '').replace(',', '.'));

            // Check if it's a valid number, otherwise return the original input
            if (isNaN(number)) {
                return num; // Return the original input (leave it unformatted if invalid)
            }

            // Format valid numbers in European style
            return number.toLocaleString('de-DE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        // Function to unformat number for form submission
        window.unformatNumber = function(num) {
            var rawNumber = num.replace(/\./g, '').replace(',', '.');

            // Ensure valid number before submitting, fallback to "0" if NaN
            var parsedNumber = parseFloat(rawNumber);
            return isNaN(parsedNumber) ? '0' : parsedNumber.toFixed(2);
        };

        // Format input fields on blur (user leaves the field)
        $('input.format-number').on('blur', function() {
            var value = $(this).val();
            var formattedValue = window.formatNumber(value);
            $(this).val(formattedValue);
        });

        // Handle form submission by unformatting the values
        $('form').on('submit', function() {
            $('input.format-number').each(function() {
                var rawValue = window.unformatNumber($(this).val());
                $(this).val(rawValue);
            });
        });
    });
</script> --}}
{{-- <script src="{{ asset('js/debug.js') }}"></script> --}}
@yield('script')
