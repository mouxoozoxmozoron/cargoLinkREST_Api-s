<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-more').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            // Retrieve company data from data attributes
            var name = this.getAttribute('data-name');
            var category = this.getAttribute('data-category');
            var routes = this.getAttribute('data-routes');
            var location = this.getAttribute('data-location');
            var banktype = this.getAttribute('data-banktype');
            var bankacc = this.getAttribute('data-bankacc');
            var contact = this.getAttribute('data-contact');
            var logoUrl = this.getAttribute('data-logo-url');

            // Display SweetAlert2 modal with company details
            Swal.fire({
                title: name,
                html: `
                    <div>
                        <p><strong>Location:</strong> ${location}</p>
                        <p><strong>Category:</strong> ${category}</p>
                        <p><strong>Bank acc:</strong> ${bankacc}</p>
                        <p><strong>Bank type:</strong> ${banktype}</p>
                        <p><strong>Contact:</strong> ${contact}</p>
                        <p><strong>Routes:</strong> ${routes}</p>
                    </div>
                `,
                imageUrl: logoUrl,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Company Logo',
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: 'Close',
                // cancelButtonText: 'More Info',
                cancelButtonAriaLabel: 'More Info',
            });
        });
    });
});
</script>

<div>
    <div class="card dasghboard_content_card">
        <h4>Your Companies</h4>
        <div class="card-body">
            {{-- <div class="card_sub_body">
                <a href="">All <span>12</span> </a>
                <a href="">Solid <span>8</span></a>
                <a href="">Available <span>4</span></a>
            </div> --}}
            <div class="custom_divider"></div>
            <section>

                {{-- start of companie card --}}


                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @if ($usercompanies->isEmpty())
                        <p>No companies found !</p>
                    @else
                        @foreach ($usercompanies as $usercompany)
                            <div class="col">
                                <div class="card h-100">
                                    <a href="{{ route('dashboard.companyorder', ['id' => $usercompany->id]) }}">
                                        <img src="{{ asset('storage/' . $usercompany->agent_logo) }}"  class="card-img-top" alt="...">

                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">{{$usercompany -> name}}</h5>
                                        <span
                                        class="text-secondary fs-7">{{ $usercompany->company_category }}
                                    </span><br>
                                        <span
                                        class="text-secondary fs-7">{{ $usercompany->routes }}
                                    </span>
                                    <button type="button" class="btn btn-link btn-more"
                                    data-name="{{ $usercompany->name }}"
                                    data-location="{{ $usercompany->location }}"
                                    data-category="{{ $usercompany->company_category }}"
                                    data-routes="{{ $usercompany->routes }}"
                                    data-contact="{{ $usercompany->contact }}"
                                    data-email="{{ $usercompany->email }}"
                                    data-banktype="{{ $usercompany->bank_type }}"
                                    data-bankacc="{{ $usercompany->bank_acount_number }}"
                                    data-logo-url="{{ asset('storage/' . $usercompany->agent_logo) }}">
                                More
                            </button>
                        </div>
                        </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{-- end of companies cards --}}
            </section>

        </div>
    </div>
</div>
