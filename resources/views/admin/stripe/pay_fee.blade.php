@extends('admin.admin_main')

@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@include("messages")

<div class="card">
    <div class="card-header">
        <h5>Pay Registration Fee</h5>
    </div>

    <div class="card-body">
        <form id="payment-form">
            @csrf

            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" value="100" readonly>
            </div>

            <div class="form-group">
                <label>Card Details</label>
                <div id="card-element" class="form-control"></div>
                <small class="text-danger" id="card-errors"></small>
            </div>

            <button type="submit" class="btn btn-primary">
                Pay with Card
            </button>
        </form>
    </div>
</div>

@endsection

@section('page-js')
<script src="https://js.stripe.com/v3/"></script>

<script>
$(document).ready(function () {

    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card');

    card.mount('#card-element');

    card.on('change', function(event) {
        $('#card-errors').text(event.error ? event.error.message : '');
    });

    $('#payment-form').on('submit', function(e) {
        e.preventDefault();

        $.post("{{ route('stripe.create.intent') }}", {
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(res) {

            stripe.createPaymentMethod({
                type: 'card',
                card: card,
            }).then(function(result) {

                if (result.error) {
                    $('#card-errors').text(result.error.message);
                    return;
                }

                $.ajax({
                    url: "{{ route('stripe.payment.confirm') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        payment_method: result.paymentMethod.id
                    },
                    success: function(resp) {
                        window.location.href = resp.redirect;
                    },
                    error: function(xhr) {
                        $('#card-errors').text(xhr.responseJSON.error);
                    }
                });

            });
        });
    });
});
</script>
@endsection
