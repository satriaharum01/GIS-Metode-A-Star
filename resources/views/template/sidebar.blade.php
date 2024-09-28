   <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
       <div class="container-fluid">
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
               <span class="navbar-toggler-icon"></span>
           </button>
           <h1 class="navbar-brand navbar-brand-autodark">
               <a href="<?= url('dashboard') ?>">
                   <img src="<?= asset('static/logo-white.svg') ?>" width="110" height="32" alt="Tabler" class="navbar-brand-image">
               </a>
           </h1>
           <div class="navbar-nav flex-row d-lg-none">
               <div class="nav-item d-none d-lg-flex me-3">
                   <div class="btn-list">
                       <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                           <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                               <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                           </svg>
                           Source code
                       </a>
                       <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                           <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                               <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                           </svg>
                           Sponsor
                       </a>
                   </div>
               </div>
               <div class="d-none d-lg-flex">
                   <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                       <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                           <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                       </svg>
                   </a>
                   <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                       <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                           <circle cx="12" cy="12" r="4" />
                           <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                       </svg>
                   </a>
                   <div class="nav-item dropdown d-none d-md-flex me-3">
                       <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                           <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                               <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                               <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                           </svg>
                           <span class="badge bg-red"></span>
                       </a>
                       <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                           <div class="card">
                               <div class="card-header">
                                   <h3 class="card-title">Last updates</h3>
                               </div>
                               <div class="list-group list-group-flush list-group-hoverable">
                                   <div class="list-group-item">
                                       <div class="row align-items-center">
                                           <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                           <div class="col text-truncate">
                                               <a href="#" class="text-body d-block">Example 1</a>
                                               <div class="d-block text-muted text-truncate mt-n1">
                                                   Change deprecated html tags to text decoration classes (#29604)
                                               </div>
                                           </div>
                                           <div class="col-auto">
                                               <a href="#" class="list-group-item-actions">
                                                   <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                       <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                   </svg>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="list-group-item">
                                       <div class="row align-items-center">
                                           <div class="col-auto"><span class="status-dot d-block"></span></div>
                                           <div class="col text-truncate">
                                               <a href="#" class="text-body d-block">Example 2</a>
                                               <div class="d-block text-muted text-truncate mt-n1">
                                                   justify-content:between ⇒ justify-content:space-between (#29734)
                                               </div>
                                           </div>
                                           <div class="col-auto">
                                               <a href="#" class="list-group-item-actions show">
                                                   <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                       <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                   </svg>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="list-group-item">
                                       <div class="row align-items-center">
                                           <div class="col-auto"><span class="status-dot d-block"></span></div>
                                           <div class="col text-truncate">
                                               <a href="#" class="text-body d-block">Example 3</a>
                                               <div class="d-block text-muted text-truncate mt-n1">
                                                   Update change-version.js (#29736)
                                               </div>
                                           </div>
                                           <div class="col-auto">
                                               <a href="#" class="list-group-item-actions">
                                                   <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                       <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                   </svg>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="list-group-item">
                                       <div class="row align-items-center">
                                           <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                           <div class="col text-truncate">
                                               <a href="#" class="text-body d-block">Example 4</a>
                                               <div class="d-block text-muted text-truncate mt-n1">
                                                   Regenerate package-lock.json (#29730)
                                               </div>
                                           </div>
                                           <div class="col-auto">
                                               <a href="#" class="list-group-item-actions">
                                                   <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                       <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                   </svg>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="nav-item dropdown">
                   <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                       <span class="avatar avatar-sm" style="background-image: url(<?= asset('static/avatars/000m.jpg') ?>)"></span>
                       <div class="d-none d-xl-block ps-2">
                           <div></div>
                           <div class="mt-1 small text-muted"></div>
                       </div>
                   </a>
                   <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                       <a href="<?= url('profil') ?>" class="dropdown-item">Profil</a>
                       <div class="dropdown-divider"></div>
                       <a href="<?= url('pengaturan') ?>" class="dropdown-item">Pengaturan</a>
                       <a href="<?= route('logout') ?>" class="dropdown-item">Keluar</a>
                   </div>
               </div>
           </div>
           <div class="collapse navbar-collapse" id="navbar-menu">
               <ul class="navbar-nav pt-lg-3">
                   <li class="nav-item <?= url()->current() == url('/dashboard') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= url('/dashboard') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <rect x="3" y="4" width="18" height="12" rx="1"></rect>
                                   <path d="M7 20h10"></path>
                                   <path d="M9 16v4"></path>
                                   <path d="M15 16v4"></path>
                                   <path d="M9 12v-4"></path>
                                   <path d="M12 12v-1"></path>
                                   <path d="M15 12v-2"></path>
                                   <path d="M12 12v-1"></path>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Dashboard
                           </span>
                       </a>
                   </li>
                   <li class="nav-item <?= url()->current() == url('/rute') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= url('/rute') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-route" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <circle cx="6" cy="19" r="2"></circle>
                                   <circle cx="18" cy="5" r="2"></circle>
                                   <path d="M12 19h4.5a3.5 3.5 0 0 0 0 -7h-8a3.5 3.5 0 0 1 0 -7h3.5"></path>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Rute (A star)
                           </span>
                       </a>
                   </li>

                   <?php if (1==1)://Auth::user()->level == ('admin')) : ?>
                       <li class="nav-item d-none <?= url()->current() == url('/laporan') ? 'active' : '' ?>">
                           <a class="nav-link" href="<?= url('/') ?>">
                               <span class="nav-link-icon d-md-none d-lg-inline-block">
                                   <!-- Download SVG icon from http://tabler-icons.io/i/home -->

                               </span>
                               <span class="nav-link-title">
                                   Laporan
                               </span>
                           </a>
                       </li>

                       <li class="nav-item <?= url()->current() == url('/halte') ? 'active' : '' ?>">
                           <a class="nav-link" href="<?= url('/halte') ?>">
                               <span class="nav-link-icon d-md-none d-lg-inline-block">
                                   <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car m-0 p-0" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                       <circle cx="7" cy="17" r="2" />
                                       <circle cx="17" cy="17" r="2" />
                                       <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                                   </svg>
                               </span>
                               <span class="nav-link-title">
                                   Halte
                               </span>
                           </a>
                       </li>

                       <li class="nav-item <?= url()->current() == url('/graf') ? 'active' : '' ?>">
                           <a class="nav-link" href="<?= url('/graf') ?>">
                               <span class="nav-link-icon d-md-none d-lg-inline-block">
                                   <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <polyline points="3 7 9 4 15 7 21 4 21 17 15 20 9 17 3 20 3 7"></polyline>
                                       <line x1="9" y1="4" x2="9" y2="17"></line>
                                       <line x1="15" y1="7" x2="15" y2="20"></line>
                                   </svg>
                               </span>
                               <span class="nav-link-title">
                                   Graf
                               </span>
                           </a>
                       </li>

                       <li class="nav-item <?= url()->current() == url('/pengguna') ? 'active' : '' ?>">
                           <a class="nav-link" href="<?= url('/pengguna') ?>">
                               <span class="nav-link-icon d-md-none d-lg-inline-block">
                                   <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <circle cx="9" cy="7" r="4"></circle>
                                       <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                       <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                       <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                   </svg>
                               </span>
                               <span class="nav-link-title">
                                   Pengguna
                               </span>
                           </a>
                       </li>
                   <?php endif; ?>

                   <li class="nav-item <?= url()->current() == url('/profil') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= url('/profil') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <circle cx="12" cy="7" r="4"></circle>
                                   <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Profil
                           </span>
                       </a>
                   </li>
                   <li class="nav-item <?= url()->current() == url('/pengaturan') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= url('/pengaturan') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                   <circle cx="12" cy="12" r="3"></circle>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Pengaturan
                           </span>
                       </a>
                   </li>
                   <li class="nav-item <?= url()->current() == url('/tentang') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= url('/tentang') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <circle cx="12" cy="12" r="9"></circle>
                                   <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                   <polyline points="11 12 12 12 12 16 13 16"></polyline>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Tentang Sistem
                           </span>
                       </a>
                   </li>

                   <li class="nav-item <?= url()->current() == route('logout') ? 'active' : '' ?>">
                       <a class="nav-link" href="<?= route('logout') ?>">
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                               <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                                   <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                               </svg>
                           </span>
                           <span class="nav-link-title">
                               Keluar
                           </span>
                       </a>
                   </li>
               </ul>
           </div>
       </div>
   </aside>