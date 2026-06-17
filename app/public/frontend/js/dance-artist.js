$(document).ready(function () {
    function showToast(msg, type = 'success') {
        const $t = $('#artistToast');
        $t.text(msg).removeClass('success error').addClass(type + ' show');
        setTimeout(() => $t.removeClass('show'), 3000);
    }

    $('.buyTicket-button').on('click', function (e) {
        e.preventDefault();
        const id = $(this).closest('.container').find('.music-performance-id').val();

        $.ajax({
            url: '/dance/create',
            method: 'POST',
            data: { music_performance_id: id },
            success: function () {
                $('.cart-counter').removeClass('d-none');
                let counter = $('.cart-counter').text() || 0;
                counter = parseInt(counter);

                counter += 1;
                $('.cart-counter').text(counter);

                toastr.success('Ticket added to cart!');
            },
            error: function () {
                toastr.error('Failed to add ticket. Try again.');
            }
        });
    });

    $('.favorite-button').on('click', function () {
        const active = $(this).hasClass('active');
        $(this).toggleClass('active');
        showToast(active ? 'Removed from favourites.' : 'Added to favourites!', 'success');
    });
});
