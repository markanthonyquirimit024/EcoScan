@extends('layout.shopping-base')

<title>My Orders</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">


<div class="container py-5">
    <h2 class="my-5 text-center">My Orders</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="mb-3">
                <input type="text" id="orderSearch" class="form-control" placeholder="Search orders...">
            </div>

            <table class="table table-striped table-hover text-center" id="ordersTable">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Date Ordered</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>#1001</td><td>Plastic Detection Sensor 1</td><td>Sept 20, 2025</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
                    <tr><td>#1002</td><td>Plastic Detection Sensor 2</td><td>Sept 18, 2025</td><td><span class="badge bg-info text-dark">Processing</span></td></tr>
                    <tr><td>#1003</td><td>Plastic Detection Sensor 1</td><td>Sept 15, 2025</td><td><span class="badge bg-primary">Shipped</span></td></tr>
                    <tr><td>#1004</td><td>Plastic Detection Sensor 2</td><td>Sept 10, 2025</td><td><span class="badge bg-success">Delivered</span></td></tr>
                    <tr><td>#1005</td><td>Plastic Detection Sensor 1</td><td>Sept 5, 2025</td><td><span class="badge bg-danger">Cancelled</span></td></tr>
                    <tr><td>#1006</td><td>Plastic Detection Sensor 1</td><td>Sept 2, 2025</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
                    <tr><td>#1007</td><td>Plastic Detection Sensor 2</td><td>Sept 1, 2025</td><td><span class="badge bg-info text-dark">Processing</span></td></tr>
                    <tr><td>#1008</td><td>Plastic Detection Sensor 1</td><td>Aug 28, 2025</td><td><span class="badge bg-primary">Shipped</span></td></tr>
                    <tr><td>#1009</td><td>Plastic Detection Sensor 2</td><td>Aug 25, 2025</td><td><span class="badge bg-success">Delivered</span></td></tr>
                    <tr><td>#1010</td><td>Plastic Detection Sensor 1</td><td>Aug 20, 2025</td><td><span class="badge bg-danger">Cancelled</span></td></tr>
                    <tr><td>#1011</td><td>Plastic Detection Sensor 2</td><td>Aug 15, 2025</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
                    <tr><td>#1012</td><td>Plastic Detection Sensor 1</td><td>Aug 10, 2025</td><td><span class="badge bg-info text-dark">Processing</span></td></tr>
                </tbody>
            </table>

            <p id="noResults" class="text-center text-muted mt-3" style="display: none;">
                No results found.
            </p>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
            </nav>

        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('orderSearch');
    const tableRows = document.querySelectorAll('#ordersTable tbody tr');
    const noResults = document.getElementById('noResults');
    const rowsPerPage = 10;
    let currentPage = 1;
    let filteredRows = Array.from(tableRows);

    function displayTable(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;

        // Hide all rows first
        tableRows.forEach(row => row.style.display = "none");

        // Show only the paginated slice of filtered rows
        filteredRows.slice(start, end).forEach(row => row.style.display = "table-row");

        setupPagination(filteredRows.length, page);
    }

    function setupPagination(totalRows, page) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const pagination = document.getElementById("pagination");
        pagination.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.classList.add("page-item");
            if (i === page) li.classList.add("active");

            const link = document.createElement("a");
            link.classList.add("page-link");
            link.href = "#";
            link.innerText = i;

            link.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = i;
                displayTable(currentPage);
            });

            li.appendChild(link);
            pagination.appendChild(li);
        }
    }

    // Search filter
    searchInput.addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();

        filteredRows = Array.from(tableRows).filter(row =>
            row.textContent.toLowerCase().includes(filter)
        );

        noResults.style.display = filteredRows.length === 0 ? "block" : "none";

        currentPage = 1;
        displayTable(currentPage);
    });

    // Initial load
    displayTable(currentPage);
</script>
