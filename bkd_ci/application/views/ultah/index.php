<style>
/* Pagination styles */
.pagination {
	display: flex;
	padding: 1em 0;
}

.pagination a,
.pagination strong {
	border: 1px solid silver;
	border-radius: 2px;
	color: black;
	padding: 0.5em;
	margin-right: 0.2em;
	text-decoration: none;
}

.pagination a:hover,
.pagination strong {
	border: 1px solid #008cba;
	background-color: #008cba;
	color: white;
}
.pagination .current-page {
    border: 1px solid #008cba;
    background-color: #008cba;
    color: white;
}

</style>
<div class="row">
<div class="col-xl-3 col-md-6">
    <div class="card bg-c-lite-green update-card">
        <div class="card-block">
            <div class="row align-items-end">
                <div class="col-8">
                    <h4 class="text-white"><?php echo $ax; ?> Orang</h4>
                    <h6 class="text-white m-b-0">Ulang Tahun Hari ini</h6>
                </div>
                <div class="col-4 text-right"  style="font-size: 40px"><b><i class="ti-gift"></i></b>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <!-- <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p> -->
        </div>
    </div>
</div>
<hr>
<br>

<div class="table-responsive ">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP BARU</th>
                        <th>NAMA PEGAWAI</th>
                        <th>TANGGAL LAHIR</th>
                        <th>NAMA SATKER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pgres as $i => $pg): ?>
                        <?php $rowNumber = $i + $offset + 1; ?>  <!-- Added $i variable assignment -->
                        <tr>
                            <td class="center"><?php echo $rowNumber ?></td> <!-- Incremented $i by 1 to start from 1 -->
                            <td class="text-bold-500"><?php echo $pg->NIP_BARU; ?></td>
                            <?php if ($pg->GELAR_BELAKANG): ?>
                            <td class="text-bold-500"><?php echo $pg->GELAR_DEPAN . $pg->NAMA . ' ' .$pg->GELAR_BELAKANG ; ?></td>
                            <?php else: ?>
                            <td class="text-bold-500"><?php echo $pg->GELAR_DEPAN . $pg->NAMA ; ?></td>
                            <?php endif; ?>
                            <td class="text-bold-500"><?php echo $pg->TANGGAL_LAHIR; ?></td>
                            <td class="text-bold-500"><?php echo $pg->NAMA_SATKER; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        
        <!-- <?php echo $pagination_links; ?> -->
        <div class="pagination">
            <?php echo str_replace('<a', '<a class="' . ($current_page == $i ? 'current-page' : '') . '"', $pagination_links); ?>
        </div>
        
    </div>
    </div>
</div>

</div>