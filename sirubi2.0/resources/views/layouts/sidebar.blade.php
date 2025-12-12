<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
						<!--begin::Logo-->
						<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
							<!--begin::Logo-->
								{{-- <a href="{{ url('/') }}" class="d-flex align-items-center">
									<!-- Logo -->
									<img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" 
										class="h-60px app-sidebar-logo-default me-2" />
									<img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" 
										class="h-50px app-sidebar-logo-minimize me-2" />

									
								</a> --}}
								<!--end::Logo-->

								<a href="{{ url('/') }}" class="d-flex align-items-center">
									<!-- Logo normal (sidebar terbuka) -->
								
										<img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" 
											class="app-sidebar-logo-default h-60px me-2" />
										<span class="fs-1 fw-bold text-white app-sidebar-logo-default" >
											SIRUBI <small class="fw-normal opacity-75">2.0</small>
										</span>
								

									<!-- Logo kecil (sidebar minimize) -->
									
										<img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" 
											class="app-sidebar-logo-minimize h-50px m2" />
									
								</a>

							<!--begin::Sidebar toggle-->
							<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
								<span class="svg-icon svg-icon-2 rotate-180">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
										<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Sidebar toggle-->
						</div>
						<!--end::Logo-->
						<!--begin::sidebar menu-->
						<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
							<!--begin::Menu wrapper-->
							<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">


								<!--begin::Menu-->
								<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
									

									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('dashboard*')  ? 'active' : '' }} " href="{{ url('dashboard') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
														<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Dashboard</span>
										</a>
										<!--end:Menu link-->
									</div>

									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('data*') || request()->routeIs('rumah*')  ? 'active' : '' }} " href="{{ url('data') }}">
											<span class="menu-icon">
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M12 3L3 10V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21V15H14V21C14 21.6 14.4 22 15 22H20C20.6 22 21 21.6 21 21V10L12 3Z" fill="currentColor"/>
														<path d="M12 3L3 10H21L12 3Z" fill="currentColor"/>
													</svg>
												</span>
											</span>
											<span class="menu-title">Data Rumah</span>
										</a>
										<!--end:Menu link-->
									</div>

									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('peta*')  ? 'active' : '' }} " href="{{ url('peta') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M8.7 4.19995L4 6.30005V18.8999L8.7 16.8V19L3.1 21.5C2.6 21.7 2 21.4 2 20.8V6C2 5.4 2.3 4.89995 2.9 4.69995L8.7 2.09998V4.19995Z" fill="currentColor"></path>
														<path d="M15.3 19.8L20 17.6999V5.09992L15.3 7.19989V4.99994L20.9 2.49994C21.4 2.29994 22 2.59989 22 3.19989V17.9999C22 18.5999 21.7 19.1 21.1 19.3L15.3 21.8998V19.8Z" fill="currentColor"></path>
														<path opacity="0.3" d="M15.3 7.19995L20 5.09998V17.7L15.3 19.8V7.19995Z" fill="currentColor"></path>
														<path opacity="0.3" d="M8.70001 4.19995V2L15.4 5V7.19995L8.70001 4.19995ZM8.70001 16.8V19L15.4 22V19.8L8.70001 16.8Z" fill="currentColor"></path>
														<path opacity="0.3" d="M8.7 16.8L4 18.8999V6.30005L8.7 4.19995V16.8Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Peta Sebaran</span>
										</a>
										<!--end:Menu link-->
									</div>

									<div data-kt-menu-trigger="click"
										class="menu-item menu-accordion {{ request()->routeIs('rekap') ? 'here show' : '' }}">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="currentColor"></path>
														<path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="currentColor"></path>
													</svg>
												</span>
											</span>
											<span class="menu-title">Rekapitulasi Kecamatan</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->

										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion">
											@foreach($kecamatans as $kec)
												@php
													$isActive = request()->get('kecamatan_id') == $kec->id_kecamatan;
												@endphp
												<div class="menu-item">
													<a class="menu-link {{ $isActive ? 'active' : '' }}"
													href="{{ route('rekap', ['kecamatan_id' => $kec->id_kecamatan]) }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">{{ $kec->nama_kecamatan }}</span>
													</a>
												</div>
											@endforeach
										</div>
										<!--end:Menu sub-->
									</div>

									
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('dokumentasi*') ? 'active' : '' }} " href="{{ url('dokumentasi') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor"></path>
														<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Data Dokumentasi</span>
										</a>
										<!--end:Menu link-->
									</div>


									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('bantuan*') ? 'active' : '' }} " href="{{ url('bantuan') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="currentColor"></path>
														<path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Data Bantuan</span>
										</a>
										<!--end:Menu link-->
									</div>


									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('polygon*') ? 'active' : '' }} " href="{{ url('polygon') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M7 20.5L2 17.6V11.8L7 8.90002L12 11.8V17.6L7 20.5ZM21 20.8V18.5L19 17.3L17 18.5V20.8L19 22L21 20.8Z" fill="currentColor"></path>
														<path d="M22 14.1V6L15 2L8 6V14.1L15 18.2L22 14.1Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Data Polygon</span>
										</a>
										<!--end:Menu link-->
									</div>

									@if (auth()->user()->level != 3)
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('users*') ? 'active' : '' }} " href="{{ url('users') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z" fill="currentColor"></path>
														<path opacity="0.3" d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Data Users</span>
										</a>
										<!--end:Menu link-->
									</div>

									
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('list') ? 'active' : '' }}"  href="{{ route('list') }}">

											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"></path>
														<rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"></rect>
														<rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Pengaduan Rumah</span>
										</a>
										<!--end:Menu link-->
									</div>


									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->routeIs('pengaduan*') ? 'active' : '' }} " href="{{ url('pengaduan') }}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"></path>
														<rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"></rect>
														<rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Pengaduan</span>
										</a>
										<!--end:Menu link-->
									</div>


									<div data-kt-menu-trigger="click"
										class="menu-item menu-accordion {{ request()->routeIs('pertanyaan*') ? 'here show' : '' }}">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="currentColor"></path>
														<path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="currentColor"></path>
													</svg>
												</span>
											</span>
											<span class="menu-title">Pengaturan</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->

										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion">


											
												<div class="menu-item">
													<a class="menu-link {{ request()->routeIs('pertanyaan') ? 'active' : '' }}"
													href="{{ route('pertanyaan') }}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Pertanyaan</span>
													</a>
												</div>

											
										</div>
										<!--end:Menu sub-->
									</div>


									@php
										$t = request()->t;

										function itemActive($key) {
											return request()->t == $key ? 'active' : '';
										}

										function groupActive($keys) {
											return in_array(request()->t, $keys) ? 'here show' : '';
										}

										function menuName($key) {
											$key = preg_replace('/^(a_|b_|c_|d_|i_|tbl_)/', '', $key);
											return ucwords(str_replace('_', ' ', $key));
										}
									@endphp

									<div data-kt-menu-trigger="click"
										class="menu-item menu-accordion {{ request()->routeIs('master*') ? 'here show' : '' }}">

										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24">
														<path d="M6.5 11C8.98 11 11 8.98 11 6.5S8.98 2 6.5 2 2 4.02 2 6.5 4.02 11 6.5 11Z" fill="currentColor"/>
														<path opacity="0.3"
															d="M13 6.5C13 4 15 2 17.5 2S22 4 22 6.5 20 11 17.5 11 13 9 13 6.5Z"
															fill="currentColor"/>
													</svg>
												</span>
											</span>
											<span class="menu-title">Data Master</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->

										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion">

											{{-- ========================================================= --}}
											{{-- ======================== GROUP A ========================= --}}
											{{-- ========================================================= --}}
											@php
												$groupA = [
													'a_kondisi_balok','a_kondisi_kolom_tiang','a_kondisi_pondasi','a_kondisi_sloof',
													'a_kondisi_struktur_atap','a_pondasi','tbl_jenis_pondasi'
												];
											@endphp

											<div data-kt-menu-trigger="click"
												class="menu-item menu-accordion mb-1 {{ groupActive($groupA) }}">

												<span class="menu-link">
													<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
													<span class="menu-title">Struktur Bangunan</span>
													<span class="menu-arrow"></span>
												</span>

												<div class="menu-sub menu-sub-accordion">

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_kondisi_balok') }}"
														href="{{ route('master.crud',['t'=>'a_kondisi_balok']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Kondisi Balok</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_kondisi_kolom_tiang') }}"
														href="{{ route('master.crud',['t'=>'a_kondisi_kolom_tiang']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Kondisi Kolom/Tiang</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_kondisi_pondasi') }}"
														href="{{ route('master.crud',['t'=>'a_kondisi_pondasi']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Kondisi Pondasi</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_kondisi_sloof') }}"
														href="{{ route('master.crud',['t'=>'a_kondisi_sloof']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Kondisi Sloof</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_kondisi_struktur_atap') }}"
														href="{{ route('master.crud',['t'=>'a_kondisi_struktur_atap']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Kondisi Struktur Atap</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('a_pondasi') }}"
														href="{{ route('master.crud',['t'=>'a_pondasi']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Pondasi</span>
														</a>
													</div>

													<div class="menu-item">
														<a class="menu-link {{ itemActive('tbl_jenis_pondasi') }}"
														href="{{ route('master.crud',['t'=>'tbl_jenis_pondasi']) }}">
															<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
															<span class="menu-title">Jenis Pondasi</span>
														</a>
													</div>

												</div>
											</div>

											{{-- ========================================================= --}}
											{{-- ======================== GROUP B ========================= --}}
											{{-- ========================================================= --}}
											@php
												$groupB = [
													'b_frekuensi_penyedotan','b_jamban','b_kondisi_jamban','b_jendela_lubang_cahaya',
													'b_kondisi_jendela_lubang_cahaya','b_ventilasi','b_kondisi_ventilasi','b_kamar_mandi',
													'b_kondisi_kamar_mandi','b_sistem_pembuangan_air_kotor','b_kondisi_sistem_pembuangan_air_kotor',
													'b_sumber_air_minum','b_kondisi_sumber_air_minum','b_sumber_listrik'
												];
											@endphp

											<div data-kt-menu-trigger="click"
												class="menu-item menu-accordion mb-1 {{ groupActive($groupB) }}">

												<span class="menu-link">
													<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
													<span class="menu-title">Sanitasi Rumah</span>
													<span class="menu-arrow"></span>
												</span>

												<div class="menu-sub menu-sub-accordion">

													@foreach ($groupB as $key)
														<div class="menu-item">
															<a class="menu-link {{ itemActive($key) }}"
															href="{{ route('master.crud',['t'=>$key]) }}">
																<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
																<span class="menu-title">{{ menuName($key) }}</span>
															</a>
														</div>
													@endforeach

												</div>
											</div>

											{{-- ========================================================= --}}
											{{-- ======================== GROUP C ========================= --}}
											{{-- ========================================================= --}}
											@php
												$groupC = [
													'c_fungsi_rumah','c_jenis_fisik_bangunan','c_ruang_keluarga_dan_tidur',
													'c_status_dtks','c_tipe_rumah'
												];
											@endphp

											<div data-kt-menu-trigger="click"
												class="menu-item menu-accordion mb-1 {{ groupActive($groupC) }}">

												<span class="menu-link">
													<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
													<span class="menu-title">Fungsi & Fisik Rumah</span>
													<span class="menu-arrow"></span>
												</span>

												<div class="menu-sub menu-sub-accordion">
													@foreach ($groupC as $key)
														<div class="menu-item">
															<a class="menu-link {{ itemActive($key) }}"
															href="{{ route('master.crud',['t'=>$key]) }}">
																<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
																<span class="menu-title">{{ menuName($key) }}</span>
															</a>
														</div>
													@endforeach
												</div>
											</div>

											{{-- ========================================================= --}}
											{{-- ======================== GROUP D ========================= --}}
											{{-- ========================================================= --}}
											@php
												$groupD = [
													'd_akses_ke_jalan','d_bangunan_berada_limbah','d_bangunan_berada_sungai','d_bangunan_menghadap_jalan',
													'd_bangunan_menghadap_sungai','d_kondisi_dinding','d_kondisi_lantai','d_kondisi_penutup_atap',
													'd_material_lantai_terluas','d_material_dinding_terluas','d_material_atap_terluas'
												];
											@endphp

											<div data-kt-menu-trigger="click"
												class="menu-item menu-accordion mb-1 {{ groupActive($groupD) }}">

												<span class="menu-link">
													<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
													<span class="menu-title">Kondisi Bangunan</span>
													<span class="menu-arrow"></span>
												</span>

												<div class="menu-sub menu-sub-accordion">
													@foreach ($groupD as $key)
														<div class="menu-item">
															<a class="menu-link {{ itemActive($key) }}"
															href="{{ route('master.crud',['t'=>$key]) }}">
																<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
																<span class="menu-title">{{ menuName($key) }}</span>
															</a>
														</div>
													@endforeach
												</div>
											</div>

											{{-- ========================================================= --}}
											{{-- ======================== GROUP I ========================= --}}
											{{-- ========================================================= --}}
											@php
												$groupI = [
													'i_aset_rumah_tempat_lain','i_aset_rumah_tanah_lain','i_besar_penghasilan','i_besar_pengeluaran',
													'i_status_kepemilikan_rumah','i_status_kepemilikan_tanah','i_bukti_kepemilikan_tanah',
													'i_jenis_kawasan_lokasi','i_status_imb','i_kecamatan','i_kelurahan','i_pekerjaan_utama',
													'i_pendidikan_terakhir','i_jumlah_kk','tbl_jenis_polygon'
												];
											@endphp

											<div data-kt-menu-trigger="click"
												class="menu-item menu-accordion mb-1 {{ groupActive($groupI) }}">

												<span class="menu-link">
													<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
													<span class="menu-title">Identitas & Sosial Ekonomi</span>
													<span class="menu-arrow"></span>
												</span>

												<div class="menu-sub menu-sub-accordion">

													@foreach ($groupI as $key)
														<div class="menu-item">
															<a class="menu-link {{ itemActive($key) }}"
															href="{{ route('master.crud',['t'=>$key]) }}">
																<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
																<span class="menu-title">{{ menuName($key) }}</span>
															</a>
														</div>
													@endforeach

												</div>
											</div>

										</div>
										<!--end:Menu sub-->
									</div>

									@endif




									<!--end:Menu item-->
									
								</div>
								<!--end::Menu-->
							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::sidebar menu-->
						<!--begin::Footer-->
						<div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
							<a href="https://preview.keenthemes.com/html/metronic/docs" class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
								<span class="btn-label">Docs & Components</span>
								<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
								<span class="svg-icon btn-icon svg-icon-2 m-0">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
										<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
										<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
										<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
										<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</a>
						</div>
						<!--end::Footer-->
					</div>