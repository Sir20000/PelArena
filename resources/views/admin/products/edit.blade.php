<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Dashboard admin - Edit product') }}<br>
        </h2>
    </x-slot>

  <x-admin.sidebar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class=" text-gray-900 dark:text-gray-100">
                    <nav class="flex border-b dark:border-gray-700 mt-4 bg-white rounded-xl dark:bg-gray-800">
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="general"> <i class="ri-settings-4-line"></i> General Information</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="max"><i class="ri-bar-chart-2-line"></i> Config</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="information"><i class="ri-money-dollar-circle-line"></i> Complement information</button>

                    </nav>
                    <form action="{{ route('admin.products.update',$id )}}" method="POST" class="px-8 py-4">
                        @csrf

                        <div class="tab-content" id="general">
                            <div class="grid col-span-2 row-span-3">
                                <div class="form-group m-4 flex flex-col col-start-1">
                                    <label for="ram"><i class="ri-text"></i> Name</label>
                                    <input type="text" name="name" class="form-control dark:bg-gray-800 rounded-xl" value="{{$id->name}}" readonly>
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="cpu"><i class="ri-quote-text"></i> Description</label>
                                    <input type="text" name="description" class="form-control dark:bg-gray-800 rounded-xl" value="{{$id->description}}">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="storage"><i class="ri-image-line"></i> Image</label>
                                    <input type="text" name="image" class="form-control dark:bg-gray-800 rounded-xl" value="{{$id->image}}">
                                </div>
                                <div class="form-group m-4 flex flex-col col-start-2">
                                    <label for="extension"><i class="ri-puzzle-line"></i> Extension</label>
                                    <input value="{{$id->extension}}" id="extension" name="extension" class="form-control dark:bg-gray-800 rounded-xl" readonly>
                                </div>

                                <div class="form-group m-4 flex flex-col">
                                    <label for="maxbyuser"><i class="ri-user-2-line"></i> Max by user</label>
                                    <input type="number" name="maxbyuser" class="form-control dark:bg-gray-800 rounded-xl" value="{{$id->maxbyuser}}">
                                </div>
                                <div class="m-4 flex flex-col">
                                    <label for="stock"><i class="ri-instance-line"></i> Stock</label>
                                    <input type="number" name="stock" class="form-control dark:bg-gray-800 rounded-xl" min="-1" step="1" value="{{$id->stock}}">
                                </div>
                            </div>
                            <div class="m-4 flex flex-col">
                                <label for="stock"><i class="ri-money-dollar-circle-line"></i> Price</label>
                                <input type="number" name="price" class="form-control dark:bg-gray-800 rounded-xl" min="0" step="0.01" value="{{$id->price}}">
                            </div>
                            <div class="form-group m-4 flex flex-col col-start-2">
                                <label for="categorie"><i class="ri-puzzle-line"></i> Categories</label>
                                <select name="categorie" id="categorie" class="form-control dark:bg-gray-800 rounded-xl">
                                     @foreach($categories as $key => $ext)
            <option value="{{ $ext['id'] }}" 
                @if($ext['id'] == $id->categorie) selected @endif>
                {{ $ext['name'] }}
            </option>
        @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Max Resource Section -->
                        <div class="tab-content" id="max">
                            <div class="grid col-span-2 row-span-3" id="max-resource-fields">
                                <!-- Dynamic fields for Max Resources will be loaded here -->
                            </div>
                        </div>

          <div class="tab-content" id="prix">
                            <div class="grid col-span-2 row-span-3" id="prix-resource-fields">
                                <!-- Dynamic fields for Prix Resources will be loaded here -->
                            </div>
                        </div>
                        <div class="tab-content" id="information">
                            <div class="grid col-span-2 row-span-3" id="information-fields">
                                <!-- Dynamic fields for Prix Resources will be loaded here -->
                            </div>
                        </div>
                        <button type="submit" class="rounded-xl bg-blue-300 p-2 mt-4"><i class="ri-save-line"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const extensions = @json($extensions);
        const config = @json($fields["config"]);
        const info = @json($fields["info"]);

        console.log("Extensions Data:", extensions); // Log the data to see what is being passed

        document.addEventListener("DOMContentLoaded", function() {
            const extensionSelect = document.getElementById("extension");
            const configResourceContainer = document.getElementById("max-resource-fields");
            const informationContainer = document.getElementById("information-fields");

            function updateFields() {
                const selected = extensionSelect.value;
                console.log("Selected Extension:", selected); // Log the selected extension

                const fields = extensions[selected]?.fileds ?? {};
                console.log("Fields for selected extension:", fields); // Log the fields for the selected extension

                if (Object.keys(fields).length === 0) {
                    console.warn("No fields found for this extension.");
                }

                // Clear previous fields
                configResourceContainer.innerHTML = '';
                informationContainer.innerHTML = '';
                let fieldCount = 0;
                // Loop through the fields and assign them to the correct tab
                for (const [key, field] of Object.entries(fields)) {
                    if (!field.information) {
                        console.log("Processing field:", key, field);

                        const label = document.createElement("label");
                        label.innerHTML = `<i class="${field.icon}"></i> ${field.name}`;

                        const input = document.createElement("input");
                        input.type = field.type;
                        input.className = "form-control dark:bg-gray-800 rounded-xl";

                        const div = document.createElement("div");
                        div.className = "form-group m-4 flex flex-col";
                        div.appendChild(label);
                        div.appendChild(input);
                        if (fieldCount == Math.floor(Object.entries(fields).length / 2)) {
                            div.classList.add("col-start-2");
                        }
                        if (field.type === "number") {
                            const maxDiv = div.cloneNode(true);
                            maxDiv.querySelector('input').name = `config[${key}]`;
                            maxDiv.querySelector('input').value = config[key];
                            configResourceContainer.appendChild(maxDiv);

                        }
                        console.log("Finish field:", key, field);
                        fieldCount++; // Increment the counter

                    }
                    if (field.information) {
                        console.log("Processing field:", key, field);

                        const label = document.createElement("label");
                        label.innerHTML = `<i class="${field.icon}"></i> ${field.name}`;

                        // Créer l'élément input ou select selon le type
                        let input;

                        if (field.type === "select") {
                            input = document.createElement("select");
                            input.className = "form-control dark:bg-gray-800 rounded-xl";
                            input.name = `info[${key}]`;

                            // Ajouter les options
                            if (Array.isArray(field.options)) {
                                field.options.forEach(option => {
                                    const opt = document.createElement("option");
                                    opt.value = option.id;
                                    opt.textContent = option.name;
                                    if (option.id == info[key]) {
                                        opt.setAttribute("selected", "");
                                    };
                                    input.appendChild(opt);
                                });





                                console.log("Select value set to:", input.value);
                            }
                        } else {
                            input = document.createElement("input");
                            input.type = field.type;
                            input.className = "form-control rounded-xl";
                            input.name = `${key}`;
                            input.value = info[key];
                        }


                        const div = document.createElement("div");
                        div.className = "form-group m-4 flex flex-col";
                        div.appendChild(label);
                        div.appendChild(input);

                        if (fieldCount == Math.floor(Object.entries(fields).length / 2)) {
                            div.classList.add("col-start-2");
                        }

                        informationContainer.appendChild(div.cloneNode(true));

                        console.log("Finish field:", key, field);
                    };
                }

            }

            extensionSelect.addEventListener("change", updateFields);
            updateFields(); // Call on load to initialize the fields
        });
    </script>


</x-app-layout>