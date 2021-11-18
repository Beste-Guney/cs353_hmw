<!DOCTYPE html>
    <head>
        <title>Main Page</title>
        <link rel='stylesheet' type='text/css' href='main.css'>
    </head>
    <body>
    <?php include "products.php" ?>
    <?php if (isset($_GET['error'])) { ?>
        <script>
        function parse_query_string(query) {
        var vars = query.split("&");
        var query_string = {};
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            var key = decodeURIComponent(pair[0]);
            var value = decodeURIComponent(pair[1]);
            // If first entry with this name
            if (typeof query_string[key] === "undefined") {
            query_string[key] = decodeURIComponent(value);
            // If second entry with this name
            } else if (typeof query_string[key] === "string") {
            var arr = [query_string[key], decodeURIComponent(value)];
            query_string[key] = arr;
            // If third or later entry with this name
            } else {
            query_string[key].push(decodeURIComponent(value));
            }
        }
        return query_string;
    }
        var query = window.location.search.substring(1);
        var qs = parse_query_string(query);
        window.alert(qs.error)</script>
            <?php }
            else if (isset($_GET['success'])) { ?>
                <script>window.alert('You successfully bought the product')</script>
                    <?php } ?>
                    <div style='text-align:center'>
                    <a muted href='./profile.php'>Go to your profile</a><br>
                    <a muted href='./logout.php'>Log Out</a>
                    </div>

    </body>
</html>