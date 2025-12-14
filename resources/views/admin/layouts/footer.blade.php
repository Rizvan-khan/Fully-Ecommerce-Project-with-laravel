  <!-- content-footer -->
    <footer class="content-footer">
        <div>© 2025 Admin - <a href="https://laborasyon.com/" target="_blank">Dashbaord</a></div>
        <!-- <div>
            <nav class="nav gap-4">
                <a href="https://themeforest.net/licenses/standard" class="nav-link">Licenses</a>
                <a href="#" class="nav-link">Change Log</a>
                <a href="#" class="nav-link">Get Help</a>
            </nav>
        </div> -->
    </footer>
    <!-- ./ content-footer -->

</div>
<!-- ./ layout-wrapper -->

<!-- Bundle scripts -->
<script src="{{ asset('admin/libs/bundle.js') }}"></script>

<!-- Apex chart -->
<script src="{{ asset('admin/libs/charts/apex/apexcharts.min.js') }}"></script>

<!-- Slick -->
<script src="{{ asset('admin/libs/slick/slick.min.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('admin/dist/js/examples/dashboard.js') }}"></script>

<!-- Main Javascript file -->
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        $('select[name="category_id"]').on('change', function() {

            let category_id = $(this).val();

            $('#sub_category').html('<option value="">Loading...</option>');

            if (category_id) {

                $.ajax({
                    url: '/get-subcategories/' + category_id,
                    type: 'GET',
                    success: function(data) {

                        $('#sub_category').empty();
                        $('#sub_category').append('<option value="">Select Sub Category</option>');

                        $.each(data, function(key, sub) {

                                console.log(sub.id);
                                console.log('Heee');

                            $('#sub_category').append('<option value="' + sub.id + '">' + sub.name + '</option>');
                        });
                    }
                });

            } else {
                $('#sub_category').html('<option value="">Select Sub Category</option>');
            }

        });

    });
</script>



</body>

</html>
