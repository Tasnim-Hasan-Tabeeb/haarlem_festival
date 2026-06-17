$(document).ready(function () {
    $('.venue').on('click', function () {
        const name = $(this).data('name');
        const location = $(this).data('location');
        const mapUrl = $(this).data('map');

        $('#venue-detail-name').text(name);
        $('#venue-detail-location').text(location);
        $('#venue-map').attr('src', mapUrl);
        $('#venueModal').addClass('open');
        $('body').css('overflow', 'hidden');
    });

    $('#closeVenueModal, #venueModal').on('click', function (e) {
        if (e.target === this) {
            $('#venueModal').removeClass('open');
            $('#venue-map').attr('src', '');
            $('body').css('overflow', '');
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('#venueModal').removeClass('open');
            $('#venue-map').attr('src', '');
            $('body').css('overflow', '');
        }
    });

    function showToast(message, type = 'success') {
        const $t = $('#danceToast');
        $t.text(message).removeClass('success error').addClass(type).addClass('show');
        setTimeout(() => $t.removeClass('show'), 3000);
    }

    $(document).on('click', '.buy-button', function (e) {
        e.preventDefault();
        const id = $(this).closest('.ticket-container').find('.music-performance-id').val();

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

    $(document).on('click', '.buy-pass-button', function (e) {
        e.preventDefault();
        const passId = $(this).data('pass-id');

        $.ajax({
            url: '/dance/addpasstobasket',
            method: 'POST',
            data: { pass_id: passId },
            success: function () {
                $('.cart-counter').removeClass('d-none');
                let counter = $('.cart-counter').text() || 0;
                counter = parseInt(counter);

                counter += 1;
                $('.cart-counter').text(counter);
                toastr.success('Pass added to cart!');
            },
            error: function () {
                toastr.error('Failed to add pass. Try again.');
            }
        });
    });

    $(document).on('click', '.favorite-button', function () {
        const isFav = $(this).hasClass('active');
        $(this).toggleClass('active');
        showToast(isFav ? 'Removed from favourites.' : 'Added to favourites!', 'success');
    });
});
