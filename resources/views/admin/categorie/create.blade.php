<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Dashboard admin - Create category') }}<br>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class=" text-gray-900 dark:text-gray-100">
                    <nav class="flex border-b dark:border-gray-700 mt-4 bg-white rounded-xl">
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="general"> <i class="ri-settings-4-line"></i> General Information</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="max"><i class="ri-bar-chart-2-line"></i> Max Resource</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="prix"><i class="ri-money-dollar-circle-line"></i> Prix Resource</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="information"><i class="ri-money-dollar-circle-line"></i> Complement information</button>

                    </nav>
                    <form action="{{ route('admin.categorie.store') }}" method="POST" class="px-8 py-4">
                        @csrf

                        <div class="tab-content" id="general">
                            <div class="grid col-span-2 row-span-3">
                                <div class="form-group m-4 flex flex-col col-start-1">
                                    <label for="ram"><i class="ri-text"></i> Name</label>
                                    <input type="text" name="name" class="form-control rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="cpu"><i class="ri-quote-text"></i> Description</label>
                                    <input type="text" name="description" class="form-control rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="storage"><i class="ri-image-line"></i> Image</label>
                                    <input type="text" name="image" class="form-control rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col col-start-2">
                                    <label for="extension"><i class="ri-puzzle-line"></i> Extension</label>
                                    <select name="extension" id="extension" class="form-control rounded-xl">
                                        @foreach($extensions as $key => $ext)
                                        <option value="{{ $key }}">{{ $ext['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group m-4 flex flex-col">
                                    <label for="maxbyuser"><i class="ri-user-2-line"></i> Max by user</label>
                                    <input type="number" name="maxbyuser" class="form-control rounded-xl">
                                </div>
                                <div class="m-4 flex flex-col">
                                    <label for="stock"><i class="ri-instance-line"></i> Stock</label>
                                    <input type="number" name="stock" class="form-control rounded-xl" min="-1" step="1">
                                </div>
                            </div>
                        </div>

                        <!-- Max Resource Section -->
                        <div class="tab-content" id="max">
                            <div class="grid col-span-2 row-span-3" id="max-resource-fields">
                                <!-- Dynamic fields for Max Resources will be loaded here -->
                            </div>
                        </div>

                        <!-- Prix Resource Section -->
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
                        <button type="submit" class="rounded-xl bg-blue-300 p-2 mt-4"><i class="ri-add-line"></i> Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const extensions = @json($extensions);
        console.log("Extensions Data:", extensions); // Log the data to see what is being passed

        document.addEventListener("DOMContentLoaded", function() {
            const extensionSelect = document.getElementById("extension");
            const maxResourceContainer = document.getElementById("max-resource-fields");
            const prixResourceContainer = document.getElementById("prix-resource-fields");
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
                maxResourceContainer.innerHTML = '';
                prixResourceContainer.innerHTML = '';
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
                        input.className = "form-control rounded-xl";

                        const div = document.createElement("div");
                        div.className = "form-group m-4 flex flex-col";
                        div.appendChild(label);
                        div.appendChild(input);
                        if (fieldCount == Math.floor(Object.entries(fields).length / 2)) {
                            div.classList.add("col-start-2");
                        }
                        if (field.type === "number") {
                            const maxDiv = div.cloneNode(true);
                            maxDiv.querySelector('input').name = `max[${key}]`;
                            maxResourceContainer.appendChild(maxDiv);
                            const prixInput = input.cloneNode(true); // Créer une autre copie pour prix
                            prixInput.name = `prix[${key}]`;
                            const prixDiv = div.cloneNode(true);
                            prixDiv.querySelector('input').name = `prix[${key}]`; // Assurer que le nom est correct dans la copie
                            prixResourceContainer.appendChild(prixDiv);
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
                            input.className = "form-control rounded-xl";
                            input.name = `info[${key}]`;

                            // Ajouter les options
                            if (Array.isArray(field.options)) {
                                field.options.forEach(option => {
                                    const opt = document.createElement("option");
                                    opt.value = option.id;
                                    opt.textContent = option.name;
                                    input.appendChild(opt);
                                });
                            }
                        } else {
                            input = document.createElement("input");
                            input.type = field.type;
                            input.className = "form-control rounded-xl";
                            input.name = `info[${key}]`;
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