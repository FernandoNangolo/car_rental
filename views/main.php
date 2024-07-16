<div class="content-page">
    <div class="greeting">
        <form method="POST" action="index.php">
            <input type="hidden" name="action" value="logout">
            <button style="color:white; background:maroon; padding: 10px; font-weight: bold;" type="submit">Logout</button>
        </form>
        <h1 style="color: #8b6d12">Welcome, <?php echo htmlspecialchars($username); ?></h1>
    </div>

    <div class="table-group">
        <div class="table-item">
            <h2><?php echo ($isAdmin ? 'All Cars' : 'Available Cars'); ?></h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($isAdmin ? $allCars : $availableCars) as $car): ?>
                          
                            
                            <tr class="car-row main-row" data-car-id="<?php echo $car['id']; ?>">

                                <td>
                                    <?php if (!empty($car['photo'])): ?>
                                        <a href="uploads/<?php echo htmlspecialchars($car['photo']); ?>" target="_blank">
                                            <img src="uploads/<?php echo htmlspecialchars($car['photo']); ?>" alt="Car Photo" width="100">
                                        </a><br>
                                    <?php else: ?>
                                        <img src="uploads/default-car.jpg" alt="No Image Available" width="100" hight="50">    
                                    <?php endif; ?>
                                </td>

                                <td class="expandable"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></td>
                                <?php if ($isAdmin): ?>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="delete_car_id" value="<?php echo $car['id']; ?>">
                                            <button type="submit" name="delete_car" <?php echo ($car['status'] === 'rented' ? 'disabled' : ''); ?> class="delete-button <?php echo ($car['status'] === 'rented' ? 'disabled' : ''); ?>">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="rent_car_id" value="<?php echo $car['id']; ?>">
                                            <button type="submit" name="rent_car">Rent</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <tr class="car-details" id="details-<?php echo $car['id']; ?>" style="display: none;">
                                <td colspan="<?php echo ($isAdmin ? '2' : '1'); ?>">
                                    <div>
                                        <strong>Manufacturer:</strong> <?php echo htmlspecialchars($car['manufacturer']); ?><br>
                                        <strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?><br>
                                        <strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?><br>
                                        <strong>Registration Plate:</strong> <?php echo htmlspecialchars($car['registration_plate']); ?><br>
                                        <strong>Type:</strong> <?php echo htmlspecialchars($car['type']); ?><br>
                                        <strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?><br>
                                        <strong>Transmission:</strong> <?php echo htmlspecialchars($car['transmission']); ?><br>
                                        <strong>Mileage:</strong> <?php echo htmlspecialchars($car['mileage']); ?> kilometers<br>
                                        <?php echo htmlspecialchars($car['description']); ?><br>                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($isAdmin): ?>
                <button style="color:white; background:darkgreen; padding: 7px; font-weight: bold;margin-top: 2px;" id="addCarBtn">Add New Car</button>

                <!-- Modal for adding a new car -->
                <div id="addCarModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Car</h2>
                        <form id="addCarForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="form-control w-50">
                                    <label for="manufacturer">Manufacturer:</label>
                                    <input type="text" id="manufacturer" name="manufacturer" required><br>
                                </div>
                                <div class="form-control w-50">
                                    <label for="brand">Brand:</label>
                                    <input type="text" id="brand" name="brand" required>                                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control w-30">
                                    <label for="model">Model:</label>
                                    <input type="text" id="model" name="model" required>
                                </div>
                                <div class="form-control w-30">
                                    <label for="registration_plate">Registration Plate:</label>
                                    <input type="text" id="registration_plate" name="registration_plate" required>
                                </div>
                                <div class="form-control w-30">
                                    <label for="type">Type:</label>
                                    <input type="text" id="type" name="type" required>
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="form-control w-30">
                                    <label for="fuel_type">Fuel Type:</label>
                                    <input type="text" id="fuel_type" name="fuel_type" required>
                                </div>
                                <div class="form-control w-30">
                                    <label for="transmission">Transmission:</label>
                                    <input type="text" id="transmission" name="transmission" required>
                                </div>
                                <div class="form-control w-30">
                                    <label for="mileage">Mileage:</label>
                                    <input type="number" id="mileage" name="mileage" required>
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="form-control">
                                    <label for="photo">Photo:</label>
                                    <input type="file" id="photo" name="photo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" required></textarea>
                                </div>
                            </div>
                            <button type="submit" id="submitBtn" name="add_car">Add Car</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="table-item">
            <h2>Rented Cars</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car</th>
                            <?php if ($isAdmin): ?>
                                <th>User</th>
                            <?php endif; ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rentedCars as $car): ?>
                            <tr class="car-row main-row" data-car-id="rented-<?php echo $car['id']; ?>">

                                <td>
                                    <?php if (!empty($car['photo'])): ?>
                                        <a href="uploads/<?php echo htmlspecialchars($car['photo']); ?>" target="_blank">
                                            <img src="uploads/<?php echo htmlspecialchars($car['photo']); ?>" alt="Car Photo" width="100">
                                        </a><br>
                                    <?php else: ?>
                                        <img src="uploads/default-car.jpg" alt="No Image Available" width="100" hight="50">    
                                    <?php endif; ?>
                                </td>

                                <td class="expandable"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></td>
                                <?php if ($isAdmin): ?>
                                    <td><?php echo htmlspecialchars($car['username']); ?></td>
                                <?php endif; ?>
                                <td>
                                    <form method="POST" action="index.php">
                                        <input type="hidden" name="release_car_id" value="<?php echo $car['id']; ?>">
                                        <button type="submit">Release</button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="car-details" id="details-rented-<?php echo $car['id']; ?>" style="display: none;">
                                <td colspan="2">
                                    <div>
                                        <strong>Manufacturer:</strong> <?php echo htmlspecialchars($car['manufacturer']); ?><br>
                                        <strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?><br>
                                        <strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?><br>
                                        <strong>Registration Plate:</strong> <?php echo htmlspecialchars($car['registration_plate']); ?><br>
                                        <strong>Type:</strong> <?php echo htmlspecialchars($car['type']); ?><br>
                                        <strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?><br>
                                        <strong>Transmission:</strong> <?php echo htmlspecialchars($car['transmission']); ?><br>
                                        <strong>Mileage:</strong> <?php echo htmlspecialchars($car['mileage']); ?> kilometers<br>
                                        <?php echo htmlspecialchars($car['description']); ?><br>                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!$isAdmin): ?>
            <div class="table-item">
                <h2>Past Rentals</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Car</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pastRentedCars as $car): ?>
                                <tr class="car-row main-row" data-car-id="past-<?php echo $car['car_id']; ?>">
                                    <td>
                                        <?php if (!empty($car['photo'])): ?>
                                            <a href="uploads/<?php echo htmlspecialchars($car['photo']); ?>" target="_blank">
                                                <img src="uploads/<?php echo htmlspecialchars($car['photo']); ?>" alt="Car Photo" width="100">
                                            </a><br>
                                        <?php else: ?>
                                            <img src="uploads/default-car.jpg" alt="No Image Available" width="100" hight="50">    
                                        <?php endif; ?>
                                    </td>
                                    <td class="expandable"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($car['rental_date']))); ?></td>
                                </tr>
                                <tr class="car-details" id="details-past-<?php echo $car['car_id']; ?>" style="display: none;">
                                    <td colspan="2">
                                        <div>
                                            <strong>Manufacturer:</strong> <?php echo htmlspecialchars($car['manufacturer']); ?><br>
                                            <strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?><br>
                                            <strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?><br>
                                            <strong>Registration Plate:</strong> <?php echo htmlspecialchars($car['registration_plate']); ?><br>
                                            <strong>Type:</strong> <?php echo htmlspecialchars($car['type']); ?><br>
                                            <strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?><br>
                                            <strong>Transmission:</strong> <?php echo htmlspecialchars($car['transmission']); ?><br>
                                            <strong>Mileage:</strong> <?php echo htmlspecialchars($car['mileage']); ?> kilometers<br>
                                            <?php echo htmlspecialchars($car['description']); ?><br>                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>

    .delete-button.disabled {
        background-color: #E0E0E0; /* Blue-grey color */
        color: #616161; /* Text color */
        cursor: not-allowed; /* Change cursor to indicate not clickable */
    }

    /* Modal styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #fefefe;
        margin: 3% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 40%; /* Could be more or less, depending on screen size */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Form styles */
    .modal-content form{
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .modal-content .form-group{
        display: flex;
        
    }
    .modal-content .form-control{
        display: flex;
        flex-direction: column;
        padding: .5rem;        
    }

    .modal-content label {
        margin: 5px 0;
        font-weight: bold;
        font-size:.8em;
    }
    .modal-content input, textarea {
        padding: .5rem;
        font-weight: bold;
        border-radius: 8px;
    }

  

    .modal-content button[type="submit"] {
        width: 30%;
        max-width: 100px; /* Adjust max-width based on your design */
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        align-self: end;
    }

    .modal-content button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }


    // Style table 
    const tables_containers = document.querySelectorAll(".table-container");

    tables_containers.forEach((tb_cont) =>{
        
        const main_rows = tb_cont.querySelectorAll(".main-row");

        main_rows.forEach((row,index) =>{
            if(index % 2 != 0 && index > 0){
                row.classList.add('colored');
            }
        });
    })


    const carRows = document.querySelectorAll('.car-row');
    const form = document.getElementById('addCarForm');
    const submitBtn = document.getElementById('submitBtn');

    carRows.forEach(row => {
        const expandable_col = row.querySelector('.expandable');
        expandable_col.addEventListener('click', function() {
            const carId = row.getAttribute('data-car-id');
            const detailsRow = document.getElementById('details-' + carId);

            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
            } else {
                detailsRow.style.display = 'none';
            }
        });
    });

    // Modal functionality
    const modal = document.getElementById("addCarModal");
    const openModalBtn = document.getElementById("addCarBtn");
    const closeModalBtn = document.querySelector(".close");
        

    openModalBtn.onclick = function() {
        modal.style.display = "block";
        
    };

    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    // Handle form submission
    
    
});


</script>
