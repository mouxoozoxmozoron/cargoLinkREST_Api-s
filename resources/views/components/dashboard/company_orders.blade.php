 <!-- Script to handle the delete confirmation -->
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const url = this.href;


                Swal.fire({
                    title: 'Do you want to delete this order?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-deliver').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const url = this.href;
                Swal.fire({
                    title: 'Is this order delivered??',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delivered!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
    </script>








<section class="py-3 py-md-5">
    <div class="container">
        {{-- <h5 class="card-title widget-card-title mb-4">kapembero cargo orders</h5> --}}
        <div class="row ">
            <div class="customcard">
                <div class="card widget-card border-light shadow-sm">
                    <div class="card-body p-4">
                        <div class="table-responsive">

                            @if ($companyorders->isNotEmpty())
                                {{-- start of table --}}

                                <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>package</th>
                                            <th>Quantity(kg)</th>
                                            <th>Destination</th>
                                            <th>Customer</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($companyorders as $companyorder)
                                            <tr>
                                                <td>
                                                    <div class="col-md-4">
                                                        {{-- <img src="{{ asset('storage/' . $usercompany->agent_logo) }}"  class="card-img-top" alt="..."> --}}
                                                        <img src="{{asset('storage/' . $companyorder->cargo_image)}}" class="img-fluid rounded-start" alt="N/A">
                                                      </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1">#HO3210</h6>
                                                    <span
                                                        class="text-secondary fs-7">{{ $companyorder->quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1">Oliver</h6>
                                                    <span
                                                        class="text-secondary fs-7">{{ $companyorder->destination }}</span>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1">
                                                        {{ $companyorder->user->first_name }}
                                                        {{ '' }}
                                                        {{ $companyorder->user->last_name }}
                                                    </h6>
                                                    <span class="text-secondary fs-7">{{ $companyorder->user->email }}
                                                    </span> <br>
                                                    <span
                                                        class="text-secondary fs-7">{{ $companyorder->user->phone_number }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($companyorder->receipt_image)
                                                        <span class="badge rounded-pill bg-success">Paid</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">On Hold</span>
                                                    @endif

                                                </td>


                                                <td>
                                                    @if ($companyorder->status == 0)
                                                        <span class="badge rounded-pill bg-warning">On hold</span>
                                                    @endif

                                                    @if ($companyorder->status == 1 && $companyorder->position == 0)
                                                        <span class="badge rounded-pill bg-info">Pending</span>
                                                    @endif

                                                    @if ($companyorder->position == 1 && $companyorder->status == 1)
                                                        <span class="badge rounded-pill bg-success">Delivered</span>
                                                    @endif
                                                </td>

                                                {{-- order actions --}}
                                                <td>
                                                    @if ($companyorder->position == 0)
                                                        <a href="{{ route('dashboard.companyorder.deliver', ['id' => $companyorder->id]) }}" class="btn btn-success btn-deliver">Delivered</a>
                                                    @endif
                                                    <a href="{{ route('dashboard.companyorder.delete', ['id' => $companyorder->id]) }}" class="btn btn-danger btn-delete">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        {{-- order actions end --}}


                                        {{-- <tr>
                                        <td>
                                            <h6 class="mb-1">#DR8672</h6>
                                            <span class="text-secondary fs-7">Web, UX Design</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">Emma</h6>
                                            <span class="text-secondary fs-7">United Kingdom</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">WordPress</h6>
                                            <span class="text-secondary fs-7">v6.3+</span>
                                        </td>
                                        <td>$950</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success">Paid</span>
                                        </td>
                                    </tr>



                                    <tr>
                                        <td>
                                            <h6 class="mb-1">#SA2910</h6>
                                            <span class="text-secondary fs-7">Web, SEO</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">Isabella</h6>
                                            <span class="text-secondary fs-7">Canada</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">React</h6>
                                            <span class="text-secondary fs-7">v18+</span>
                                        </td>
                                        <td>$700</td>
                                        <td>
                                            <span class="badge rounded-pill bg-info">On Hold</span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <h6 class="mb-1">#BD1019</h6>
                                            <span class="text-secondary fs-7">SEM, SEO</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">William</h6>
                                            <span class="text-secondary fs-7">UAE</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">Vue</h6>
                                            <span class="text-secondary fs-7">v3+</span>
                                        </td>
                                        <td>$875</td>
                                        <td>
                                            <span class="badge rounded-pill bg-warning">Negotiating</span>
                                        </td>
                                    </tr> --}}



                                    </tbody>
                                </table>
                            @else
                                <span>No order available</span>
                            @endif

                            {{-- end of table --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
