    <!-- Sidebar Start -->
    <aside class="left-sidebar">
    	<!-- Sidebar scroll-->
    	<div>
    		<div class="brand-logo d-flex align-items-center justify-content-between">
    			<a href="<?=base_url('Cadmin/dashboard')?>" class="text-nowrap logo-img">
    				<table>
    					<tbody>
    						<tr>
    							<td><img src="<?=base_url()?>assets/img/BaliBlissLogo.png" heigth="40"
    									width="140"></td>
    							<td class="text-dark fs-3"><b> </b></td>
    						</tr>
    					</tbody>
    				</table>
    			</a>
    			<div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
    				<i class="ti ti-x fs-8"></i>
    			</div>
    		</div>
    		<!-- Sidebar navigation-->
    		<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
    			<ul id="sidebarnav">
    				<!-- <li class="nav-small-cap">
    					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
    					<span class="hide-menu">Home</span>
    				</li> -->
    				<li class="sidebar-item">
    					<a class="sidebar-link" href="<?=base_url('Cadmin/dashboard')?>" aria-expanded="false">
    						<span>
    							<i class="ti ti-layout-dashboard"></i>
    						</span>
    						<span class="hide-menu">Dashboard</span>
    					</a>
    				</li>
    				<!-- <li class="nav-small-cap">
    					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
    					<span class="hide-menu">Fitur</span>
    				</li> -->
    				
    				<li class="sidebar-item">
    					<a class="sidebar-link" href="<?=base_url('Cadmin/pengguna')?>" aria-expanded="false">
    						<span>
    							<i class="ti ti-user"></i>
    						</span>
    						<span class="hide-menu">Data Pengguna</span>
    					</a>
    				</li>
    				<li class="sidebar-item">
    					<a class="sidebar-link" href="<?=base_url('Cadmin/tempatwisata')?>" aria-expanded="false">
    						<span>
    							<i class="ti ti-building-community"></i>
    						</span>
    						<span class="hide-menu">Data Tempat Wisata</span>
    					</a>
    				</li>
					<li class="sidebar-item">
    					<a class="sidebar-link" href="<?=base_url('Cadmin/pengelola')?>" aria-expanded="false">
    						<span>
    							<i class="ti ti-user-check"></i>
    						</span>
    						<span class="hide-menu">Pengajuan Pengelola</span>
    					</a>
    				</li>
					<li class="sidebar-item">
    					<a class="sidebar-link" href="<?=base_url('Cadmin/sponsorship')?>" aria-expanded="false">
    						<span>
    							<i class="ti ti-folder-plus"></i>
    						</span>
    						<span class="hide-menu">Pengajuan Sponsorship</span>
    					</a>
    				</li>
    			</ul>

    		</nav>
    		<!-- End Sidebar navigation -->
    	</div>
    	<!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
