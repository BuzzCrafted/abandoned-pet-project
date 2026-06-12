<footer role="contentinfo">
    <div id="footer"
        class="bg-secondary min-h-14 before:bg-footer-line before:block before:relative before:p-6 before:-top-8 before:content-[] before:w-full before:h-14 before:bg-cover">

    </div>
    <div class="p-4 text-center text-sm text-inverse bg-primary">
        @php
            $currentYear = date('Y');
            $startYear = 2020;
            echo '&copy; ' .
                ($currentYear > $startYear ? $startYear . '-' : '') .
                $currentYear .
                ' Abandoned Pet Project. All rights reserved.';
        @endphp
    </div>
</footer>
