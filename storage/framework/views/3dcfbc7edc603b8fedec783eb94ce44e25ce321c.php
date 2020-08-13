<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <base target="_top">

        <title>Redirecting...</title>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var redirectUrl = "<?php echo $authUrl; ?>";
                if (window.top == window.self) {
                    // If the current window is the 'parent', change the URL by setting location.href
                    window.top.location.href = redirectUrl;
                } else {
                    // If the current window is the 'child', change the parent's URL with postMessage
                    normalizedLink = document.createElement('a');
                    normalizedLink.href = redirectUrl;

                    data = JSON.stringify({
                        message: 'Shopify.API.remoteRedirect',
                        data: { location: redirectUrl },
                    });
                    window.parent.postMessage(data, "https://<?php echo e($shopDomain); ?>");
                }
            });
        </script>
    </head>
    <body>
    </body>
</html><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/vendor/ohmybrew/laravel-shopify/src/ShopifyApp/resources/views/auth/fullpage_redirect.blade.php ENDPATH**/ ?>