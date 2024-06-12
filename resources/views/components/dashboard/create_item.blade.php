<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->

    <div>
        <span class="new_item">New item</span>
        <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
        <center class="login_form_box">
            @if (session('item_failure'))
                <span>
                    {{session('item_failure') }}
                </span>
            @endif

            <form class="login_form" action="{{ route('new_item_check') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- item images --}}
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="file" id="form2Example1" name="item_file" class="form-control" required multiple />
                    <label class="form-label" for="form2Example1">Item Image</label>
                    <ul class="file-list" id="fileList"></ul>
                </div>

                <!-- first name input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="form2Example1" name="item_name" class="form-control" required />
                    <label class="form-label" for="form2Example1">Item Name</label>
                </div>

                {{-- description --}}
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea id="form2Example1" name="description" class="form-control" rows="3" required></textarea>
                    <label class="form-label" for="form2Example1">Description</label>
                </div>

                <!-- price   -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="number" id="form2Example1" name="price" class="form-control" required
                        placeholder="TZS:" />
                    <label class="form-label" for="form2Example1">Item price</label>
                </div>

                <!-- category input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select id="form2Example1" name="category" class="form-control" required>
                        <option value="" disabled selected>Select item category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="form2Example1">Category</label>
                </div>

                {{-- location --}}
                <div data-mdb-input-init class="form-outline mb-4">
                    <select id="form2Example1" name="location" class="form-control" required>
                        <option value="" disabled selected>Select Your location</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="form2Example1">Location</label>
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Publish</button>

            </form>
        </center>
    </div>

</div>



<script>
    document.getElementById('form2Example1').addEventListener('change', function() {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const li = document.createElement('li');

            // Display the image
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 100; // Set width for example
            img.height = 100; // Set height for example
            li.appendChild(img);

            // Display the file name
            const span = document.createElement('span');
            span.textContent = file.name;
            li.appendChild(span);

            // Add a "Cancel" button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
            removeBtn.textContent = 'Cancel';
            removeBtn.addEventListener('click', function() {
                fileList.removeChild(li);
                // Remove the file from the input field
                const files = Array.from(document.getElementById('form2Example1').files);
                const index = files.indexOf(file);
                if (index !== -1) {
                    files.splice(index, 1);
                    document.getElementById('form2Example1').files = new FileList(files);
                }
            });
            li.appendChild(removeBtn);

            fileList.appendChild(li);
        }
    });
</script>
