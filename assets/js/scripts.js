$(document).ready(function() {
    $('#search').on('keyup', function() {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: "search_suggestions.php",
                method: "POST",
                data: {query: query},
                success: function(data) {
                    $('#searchList').fadeIn();
                    $('#searchList').html(data);
                }
            });
        } else {
            $('#searchList').fadeOut();
        }
    });

    $(document).on('click', 'li', function() {
        $('#search').val($(this).text());
        $('#searchList').fadeOut();
    });
});
