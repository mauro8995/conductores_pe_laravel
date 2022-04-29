@include('partials.top-index')
@section('title', 'Inicio')
<main>
    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
        <div class="container">
            <a class="navbar-brand text-dark" href="index.html">SB UI Kit Pro</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mr-lg-5">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home </a></li>
                    <li class="nav-item dropdown dropdown-xl no-caret">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownDemos" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Landings<i class="fas fa-chevron-right dropdown-arrow"></i></a>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in-up mr-lg-n15" aria-labelledby="navbarDropdownDemos">
                            <div class="row no-gutters">
                                <div class="col-lg-5 p-lg-3 bg-img-cover overlay overlay-primary overlay-70 d-none d-lg-block" style='background-image: url("https://source.unsplash.com/mqO0Rf-PUMs/500x350")'>
                                    <div class="d-flex h-100 w-100 align-items-center justify-content-center">
                                        <div class="text-white text-center z-1">
                                            <div class="mb-3">Multipurpose landing pages for a variety of projects.</div>
                                            <a class="btn btn-white btn-sm text-primary rounded-pill" href="index.html">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 p-lg-5">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h6 class="dropdown-header text-primary">Applications</h6>
                                            <a class="dropdown-item" href="landing-app-mobile.html">Mobile App</a><a class="dropdown-item" href="landing-app-desktop.html">Desktop App</a>
                                            <div class="dropdown-divider border-0"></div>
                                            <h6 class="dropdown-header text-primary">Business</h6>
                                            <a class="dropdown-item" href="landing-multipurpose.html">Multipurpose</a><a class="dropdown-item" href="landing-agency.html">Agency</a><a class="dropdown-item" href="landing-press.html">Press</a><a class="dropdown-item" href="landing-directory.html">Directory</a><a class="dropdown-item" href="landing-rental.html">Rental</a><a class="dropdown-item" href="landing-real-estate.html">Real Estate</a><a class="dropdown-item" href="landing-classifieds.html">Classifieds</a>
                                            <div class="dropdown-divider border-0"></div>
                                            <h6 class="dropdown-header text-primary">Lead Generation</h6>
                                            <a class="dropdown-item" href="landing-lead-capture.html">Lead Capture</a>
                                            <div class="dropdown-divider border-0 d-lg-none"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="dropdown-header text-primary">Personal</h6>
                                            <a class="dropdown-item" href="landing-resume.html">Resume</a><a class="dropdown-item" href="landing-portfolio.html">Portfolio</a>
                                            <div class="dropdown-divider border-0"></div>
                                            <h6 class="dropdown-header text-primary">Header Styles</h6>
                                            <a class="dropdown-item" href="header-basic.html">Basic</a><a class="dropdown-item" href="header-basic-signup.html">Basic (Signup)</a><a class="dropdown-item" href="header-graphic.html">Graphic</a><a class="dropdown-item" href="header-graphic-signup.html">Graphic (Signup)</a><a class="dropdown-item" href="header-inner-page.html">Inner Page</a><a class="dropdown-item" href="header-nav-only.html">Nav Only</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-lg no-caret">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownPages" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages<i class="fas fa-chevron-right dropdown-arrow"></i></a>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="navbarDropdownPages">
                            <div class="row no-gutters">
                                <div class="col-lg-6 p-lg-5">
                                    <h6 class="dropdown-header text-primary">Company</h6>
                                    <a class="dropdown-item" href="page-basic.html">Basic Page</a><a class="dropdown-item" href="page-company-about.html">About</a><a class="dropdown-item" href="page-company-pricing.html">Pricing</a><a class="dropdown-item" href="page-company-contact.html">Contact</a><a class="dropdown-item" href="page-company-terms.html">Terms</a>
                                    <div class="dropdown-divider border-0"></div>
                                    <h6 class="dropdown-header text-primary">Support</h6>
                                    <a class="dropdown-item" href="page-help-center.html">Help Center</a><a class="dropdown-item" href="page-help-knowledgebase.html">Knowledgebase</a><a class="dropdown-item" href="page-help-message-center.html">Message Center</a><a class="dropdown-item" href="page-help-support-ticket.html">Support Ticket</a>
                                    <div class="dropdown-divider border-0 d-lg-none"></div>
                                </div>
                                <div class="col-lg-6 p-lg-5">
                                    <h6 class="dropdown-header text-primary">Careers</h6>
                                    <a class="dropdown-item" href="page-careers-overview.html">Careers List</a><a class="dropdown-item" href="page-careers-listing.html">Position Details</a>
                                    <div class="dropdown-divider border-0"></div>
                                    <h6 class="dropdown-header text-primary">Blog</h6>
                                    <a class="dropdown-item" href="page-blog-overview.html">Overview</a><a class="dropdown-item" href="page-blog-post.html">Post</a><a class="dropdown-item" href="page-blog-archive.html">Archive</a>
                                    <div class="dropdown-divider border-0"></div>
                                    <h6 class="dropdown-header text-primary">Portfolio</h6>
                                    <a class="dropdown-item" href="page-portfolio-grid.html">Grid</a><a class="dropdown-item" href="page-portfolio-large-grid.html">Large Grid</a><a class="dropdown-item" href="page-portfolio-masonry.html">Masonry</a><a class="dropdown-item" href="page-portfolio-case-study.html">Case Study</a><a class="dropdown-item" href="page-portfolio-project.html">Project</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-caret">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Documentation<i class="fas fa-chevron-right dropdown-arrow"></i></a>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                            <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-ui-kit-pro/quickstart" target="_blank"
                                ><div class="icon-stack bg-primary-soft text-primary mr-4"><i class="fas fa-book-open"></i></div>
                                <div>
                                    <div class="small text-gray-500">Documentation</div>
                                    Usage instructions and reference
                                </div></a
                            >
                            <div class="dropdown-divider m-0"></div>
                            <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-ui-kit-pro/components" target="_blank"
                                ><div class="icon-stack bg-primary-soft text-primary mr-4"><i class="fas fa-code"></i></div>
                                <div>
                                    <div class="small text-gray-500">Components</div>
                                    Code snippets and reference
                                </div></a
                            >
                            <div class="dropdown-divider m-0"></div>
                            <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-ui-kit-pro/changelog" target="_blank"
                                ><div class="icon-stack bg-primary-soft text-primary mr-4"><i class="fas fa-file"></i></div>
                                <div>
                                    <div class="small text-gray-500">Changelog</div>
                                    Updates and changes
                                </div></a
                            >
                        </div>
                    </li>
                </ul>
                <a class="btn-teal btn rounded-pill px-4 ml-lg-4" href="https://shop.startbootstrap.com/sb-ui-kit-pro">Buy Now<i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </nav>
    <header class="page-header page-header-dark bg-img-repeat bg-primary" style='background-image: url("assets/img/pattern-shapes.png")'>
        <div class="page-header-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 text-center">
                        <h1 class="page-header-title">Buy and sell used items</h1>
                        <p class="page-header-text mb-5">Out with the old, in with the new! Your trash is another's treasure. Start making money, or find great deals today!</p>
                        <a class="btn btn-marketing rounded-pill btn-teal" href="#!">Start Selling</a><a class="btn btn-link btn-marketing rounded-pill" href="#!">Browse Categories</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-border-waves text-light">
            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                <defs>
                    <style>
                        .a {
                            fill: none;
                        }
                        .b {
                            clip-path: url(#a);
                        }
                        .d {
                            opacity: 0.5;
                            isolation: isolate;
                        }
                    </style>
                    <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                </defs>
                <title>wave</title>
                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
            </svg>
        </div>
    </header>
    <section class="bg-light py-10">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-4 mb-5">
                    <a class="card card-link border-top border-top-lg border-primary lift text-center o-visible h-100" href="#!"
                        ><div class="card-body">
                            <div class="icon-stack icon-stack-xl bg-primary-soft text-primary mb-4 mt-n5 z-1 shadow"><i data-feather="user"></i></div>
                            <h5>Sales</h5>
                            <p class="card-text">Ready to open an account? Have questions about purchasing a product?</p>
                        </div>
                        <div class="card-footer">
                            <div class="text-primary font-weight-bold d-inline-flex align-items-center">Contact Sales<i class="fas fa-arrow-right text-xs ml-1"></i></div></div
                    ></a>
                </div>
                <div class="col-lg-4 mb-5">
                    <a class="card card-link border-top border-top-lg border-secondary lift text-center o-visible h-100" href="#!"
                        ><div class="card-body">
                            <div class="icon-stack icon-stack-xl bg-secondary-soft text-secondary mb-4 mt-n5 z-1 shadow"><i data-feather="life-buoy"></i></div>
                            <h5>Support</h5>
                            <p class="card-text">Need help with a product that you just purchased? Need help with your account?</p>
                        </div>
                        <div class="card-footer">
                            <div class="text-secondary font-weight-bold d-inline-flex align-items-center">Contact Support<i class="fas fa-arrow-right text-xs ml-1"></i></div></div
                    ></a>
                </div>
                <div class="col-lg-4 mb-5">
                    <a class="card card-link border-top border-top-lg border-teal lift text-center o-visible h-100" href="#!"
                        ><div class="card-body">
                            <div class="icon-stack icon-stack-xl bg-teal-soft text-teal mb-4 mt-n5 z-1 shadow"><i data-feather="tv"></i></div>
                            <h5>Media</h5>
                            <p class="card-text">Looking to contact our media team for a press release or related story?</p>
                        </div>
                        <div class="card-footer">
                            <div class="text-teal font-weight-bold d-inline-flex align-items-center">Contact Media<i class="fas fa-arrow-right text-xs ml-1"></i></div></div
                    ></a>
                </div>
            </div>
        </div>
    </section>
</main>




@include('partials.footer-index')
