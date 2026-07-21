<div class="container-fluid customer-create-page">

    <!-- Page Header -->

    <div class="customer-page-header mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Customer

            </h2>

            <p class="text-muted mb-0">

                Update customer information.

            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="<?= base_url('customers/show/' . $customer['id']) ?>"
                class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-2"></i>

                Back to Profile

            </a>

        </div>

    </div>


    <form
        action="<?= base_url('customers/update/' . $customer['id']) ?>"
        method="POST"
        enctype="multipart/form-data">


        <div class="row g-4">


            <!-- CUSTOMER INFORMATION -->

            <div class="col-lg-8">


                <div class="card customer-form-card">


                    <div class="card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="form-section-icon">

                                <i class="fas fa-user"></i>

                            </div>


                            <div>

                                <h5 class="fw-bold mb-1">

                                    Customer Information

                                </h5>

                                <small class="text-muted">

                                    Update personal information

                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body">


                        <div class="row g-4">


                            <!-- Full Name -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Full Name

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-user"></i>

                                    </span>


                                    <input
                                        type="text"
                                        name="fullname"
                                        class="form-control"
                                        value="<?= htmlspecialchars($customer['fullname']) ?>"
                                        required>

                                </div>

                            </div>


                            <!-- Gender -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Gender

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-venus-mars"></i>

                                    </span>


                                    <select
                                        name="gender"
                                        class="form-select"
                                        required>


                                        <option value="">

                                            Select Gender

                                        </option>


                                        <option
                                            value="Male"
                                            <?= $customer['gender'] === 'Male'
                                                ? 'selected'
                                                : '' ?>>

                                            Male

                                        </option>


                                        <option
                                            value="Female"
                                            <?= $customer['gender'] === 'Female'
                                                ? 'selected'
                                                : '' ?>>

                                            Female

                                        </option>


                                    </select>

                                </div>

                            </div>


                            <!-- Phone -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Phone Number

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-phone"></i>

                                    </span>


                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        value="<?= htmlspecialchars($customer['phone']) ?>"
                                        required>

                                </div>

                            </div>


                            <!-- Email -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Email Address

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-envelope"></i>

                                    </span>


                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="<?= htmlspecialchars($customer['email'] ?? '') ?>">

                                </div>

                            </div>


                            <!-- Occupation -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Occupation

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-briefcase"></i>

                                    </span>


                                    <input
                                        type="text"
                                        name="occupation"
                                        class="form-control"
                                        value="<?= htmlspecialchars($customer['occupation'] ?? '') ?>">

                                </div>

                            </div>


                            <!-- Status -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Status

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-circle-check"></i>

                                    </span>


                                    <select
                                        name="status"
                                        class="form-select">


                                        <option
                                            value="Active"
                                            <?= $customer['status'] === 'Active'
                                                ? 'selected'
                                                : '' ?>>

                                            Active

                                        </option>


                                        <option
                                            value="Inactive"
                                            <?= $customer['status'] === 'Inactive'
                                                ? 'selected'
                                                : '' ?>>

                                            Inactive

                                        </option>


                                    </select>

                                </div>

                            </div>


                            <!-- Address -->

                            <div class="col-12">

                                <label class="form-label">

                                    Address

                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-location-dot"></i>

                                    </span>


                                    <textarea
                                        name="address"
                                        rows="4"
                                        class="form-control"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            <!-- PROFILE PICTURE -->

            <div class="col-lg-4">


                <div class="card customer-form-card">


                    <div class="card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="form-section-icon">

                                <i class="fas fa-camera"></i>

                            </div>


                            <div>

                                <h5 class="fw-bold mb-1">

                                    Profile Picture

                                </h5>

                                <small class="text-muted">

                                    Update customer photo

                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body text-center">


                        <?php

                        $picture = !empty($customer['picture'])
                            ? $customer['picture']
                            : 'default.png';

                        ?>


                        <div class="customer-image-wrapper">


                            <img
                                src="<?= asset('uploads/customers/' . $picture) ?>"
                                id="picturePreview"
                                alt="Customer Picture">


                            <label
                                for="picture"
                                class="image-upload-button">


                                <i class="fas fa-camera"></i>


                            </label>


                        </div>


                        <input
                            type="file"
                            name="picture"
                            id="picture"
                            class="form-control mt-4"
                            accept="image/jpeg,image/png,image/webp">


                        <small class="text-muted d-block mt-2">

                            JPG, PNG or WEBP

                        </small>


                    </div>

                </div>


                <!-- ACTIONS -->

                <div class="customer-form-actions mt-4">


                    <a
                        href="<?= base_url('customers/show/' . $customer['id']) ?>"
                        class="btn btn-outline-secondary">


                        Cancel


                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">


                        <i class="fas fa-save me-2"></i>


                        Update Customer


                    </button>


                </div>


            </div>


        </div>


    </form>

</div>


<script>

document
    .getElementById('picture')
    .addEventListener('change', function (event) {

        const file =
            event.target.files[0];

        if (file) {

            document
                .getElementById('picturePreview')
                .src =
                URL.createObjectURL(file);

        }

    });

</script>