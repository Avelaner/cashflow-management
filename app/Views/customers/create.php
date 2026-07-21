<?php

use App\Services\PermissionService;

?>

<div class="container-fluid customer-create-page">

    <!-- Page Header -->
    <div class="customer-page-header mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-2">

                <a
                    href="<?= base_url('customers') ?>"
                    class="text-decoration-none text-muted">

                    <i class="fas fa-users"></i>

                    Customers

                </a>

                <i class="fas fa-chevron-right text-muted small"></i>

                <span class="text-muted">

                    Add Customer

                </span>

            </div>

            <h2 class="fw-bold mb-1">

                Add New Customer

            </h2>

            <p class="text-muted mb-0">

                Register a new customer and keep their information organized.

            </p>

        </div>

        <a
            href="<?= base_url('customers') ?>"
            class="btn btn-light border">

            <i class="fas fa-arrow-left me-2"></i>

            Back to Customers

        </a>

    </div>


    <!-- Customer Form -->
    <form
        action="<?= base_url('customers/store') ?>"
        method="POST"
        enctype="multipart/form-data">

        <div class="row g-4">

            <!-- Main Information -->
            <div class="col-xl-8">

                <div class="card customer-form-card">

                    <div class="card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="form-section-icon">

                                <i class="fas fa-user"></i>

                            </div>

                            <div>

                                <h5 class="mb-1 fw-bold">

                                    Personal Information

                                </h5>

                                <small class="text-muted">

                                    Enter the customer's basic information

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

                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-user"></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="fullname"
                                        class="form-control"
                                        placeholder="Enter full name"
                                        required>

                                </div>

                            </div>


                            <!-- Gender -->
                            <div class="col-md-6">

                                <label class="form-label">

                                    Gender

                                    <span class="text-danger">*</span>

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

                                            Select gender

                                        </option>

                                        <option value="Male">

                                            Male

                                        </option>

                                        <option value="Female">

                                            Female

                                        </option>

                                    </select>

                                </div>

                            </div>


                            <!-- Phone -->
                            <div class="col-md-6">

                                <label class="form-label">

                                    Phone Number

                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-phone"></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        placeholder="08000000000"
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
                                        placeholder="customer@example.com">

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
                                        placeholder="e.g. Business Owner">

                                </div>

                            </div>


                            <!-- Status -->
                            <div class="col-md-6">

                                <label class="form-label">

                                    Account Status

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-circle-check"></i>

                                    </span>

                                    <select
                                        name="status"
                                        class="form-select">

                                        <option value="Active">

                                            Active

                                        </option>

                                        <option value="Inactive">

                                            Inactive

                                        </option>

                                    </select>

                                </div>

                            </div>


                            <!-- Address -->
                            <div class="col-12">

                                <label class="form-label">

                                    Residential Address

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text align-items-start pt-3">

                                        <i class="fas fa-location-dot"></i>

                                    </span>

                                    <textarea
                                        name="address"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Enter customer's full address"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Form Actions -->
                <div class="customer-form-actions mt-4">

                    <a
                        href="<?= base_url('customers') ?>"
                        class="btn btn-light border">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary px-4">

                        <i class="fas fa-user-plus me-2"></i>

                        Create Customer

                    </button>

                </div>

            </div>


            <!-- Right Column -->
            <div class="col-xl-4">

                <!-- Profile Picture -->
                <div class="card customer-form-card mb-4">

                    <div class="card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="form-section-icon">

                                <i class="fas fa-camera"></i>

                            </div>

                            <div>

                                <h5 class="mb-1 fw-bold">

                                    Profile Picture

                                </h5>

                                <small class="text-muted">

                                    Upload a customer photo

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body text-center">

                        <div class="customer-image-wrapper mb-3">

                            <img
                                src="<?= asset('images/default-user.png') ?>"
                                id="picturePreview"
                                alt="Customer Preview">

                            <label
                                for="picture"
                                class="image-upload-button">

                                <i class="fas fa-camera"></i>

                            </label>

                        </div>

                        <h6 class="fw-semibold mb-1">

                            Customer Photo

                        </h6>

                        <p class="text-muted small mb-3">

                            JPG, PNG or WEBP

                        </p>

                        <input
                            type="file"
                            name="picture"
                            id="picture"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp">

                    </div>

                </div>


                <!-- Information Card -->
                <div class="customer-info-card">

                    <div class="d-flex gap-3">

                        <i class="fas fa-circle-info"></i>

                        <div>

                            <h6 class="fw-bold">

                                Customer Registration

                            </h6>

                            <p class="small mb-0">

                                Customer codes are generated automatically after registration. You can update customer information later from their profile.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

document
    .getElementById('picture')
    .addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (file) {

            document
                .getElementById('picturePreview')
                .src = URL.createObjectURL(file);

        }

    });

</script>