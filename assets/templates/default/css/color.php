<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$color = "#ff8"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}



//third color
if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor($color)) {
    $secondColor = "#336699";
}
?>

.account-left::after, .banner-section::before, .dashboard-right-sidebar-header {
    background-color: <?php echo $secondColor; ?>;
}

.text--base, .dashboard-right-btn a {
    color: <?php echo $color; ?> !important;
}
.dashboard-right-btn a {
    background-color: <?php echo $color; ?>29;
}

.btn--base, .dashboard-right-btn a:hover {
    background: <?php echo $color; ?>;
}

.banner-widget, .header-bottom-area .navbar-collapse .main-menu li .sub-menu {
    border-color: <?php echo $color; ?>;
}

.header-bottom-area .navbar-collapse .main-menu li .sub-menu li:hover a {
    color: <?php echo $color; ?>;
}

.submit-btn {
    background: <?php echo $color; ?>;
}

.section-header .horizontal-gradient {
    background: <?php echo $color; ?>;
}

.how-it-works-content .horizontal-gradient {
    background: <?php echo $color; ?>;
}

.header-section.header-fixed .header-bottom-area {
    border-bottom: 2px solid <?php echo $color; ?>;
}

.service-icon {
    color: <?php echo $color; ?>;
}

.social-link-list li a:hover {
    background-color: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}

.scrollToTop, ::selection {
    background: <?php echo $color; ?>;
}

.blog-content .title a:hover {
    color: <?php echo $color; ?>;
}
.form--control:focus {
    border-color: <?php echo $color; ?>;
}

.statistics-icon {
    background: <?php echo $color; ?>;
}

.client-thumb::after {
    background-color: <?php echo $color; ?>;
}

.client-content .client-quote {
    background: <?php echo $secondColor; ?>;
    color: <?php echo $color; ?>;
}

.faq-wrapper .faq-item {
    background-color: <?php echo $color; ?>0d;
    border: 1px solid <?php echo $color; ?>;
}

.faq-wrapper .faq-item .right-icon {
    background-color: <?php echo $color; ?>;
}

.work-icon {
    background-color: <?php echo $color; ?>0d;
    border: 1px solid <?php echo $color; ?>;
    color: <?php echo $color; ?>;
}

.footer-item {
    background: <?php echo $secondColor; ?>b3;
    border: 2px solid <?php echo $color; ?>;
}

.footer-item .footer-content .title {
    color: <?php echo $color; ?>;
}

.footer-item .footer-content .sub-title {
    color: <?php echo $color; ?>;
}

.footer-item .footer-icon {
    color: <?php echo $color; ?>;
    font-size: 60px;
}
.brand-item {
    border: 2px solid <?php echo $color; ?>;
}

.scrollToTop {
    background: <?php echo $color; ?>;
}

.input-group-text {
    background: <?php echo $color; ?>;
}


.triangle {
    border-bottom: 54px solid <?php echo $color; ?>;
}

h1, h2, h3, h4, h5, h6 {
    color: <?php echo $secondColor; ?>;
}

.copyright-wrapper {
    background-color: <?php echo $secondColor; ?>;
}

.footer-section {
    background-color: <?php echo $secondColor; ?>;
}

*::-webkit-scrollbar-button {
  background-color: <?php echo $color; ?>;
}

*::-webkit-scrollbar-thumb {
  background-color: <?php echo $color; ?>;
}
.breadcrumb-item a {
    color: <?php echo $color; ?>;
}

.breadcrumb-item.active::before {
    color: <?php echo $color; ?>;
}

.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link {
  background-color: <?php echo $color; ?>;
}

.breadcrumb {
    background-color: <?php echo $secondColor; ?>;
}

.contact-info-content .sub-title {
    color: <?php echo $secondColor; ?>;
}

.custom-check-group label::before {
    border: 1px solid <?php echo $color; ?>;
}

.custom-check-group input:checked + label::before {
    background-color: <?php echo $color; ?>;
}

.modal-content {
    border: 2px solid <?php echo $color; ?>;
}

.page-container .sidebar-menu .logo-env .sidebar-collapse a, .page-container .sidebar-menu .logo-env .sidebar-mobile-menu a {
    color: <?php echo $color; ?>;
}

.page-container .sidebar-menu::before {
    border-bottom: 1px solid <?php echo $color; ?>;
}

.header-user-thumb {
    background: <?php echo $color; ?>;
}

.page-container .sidebar-menu .sidebar-main-menu li.active a {
    background-color: <?php echo $color; ?>1a;
    color: <?php echo $color; ?>;
}

.page-container .sidebar-menu .sidebar-main-menu li.has-sub a::before {
    color: <?php echo $color; ?>;
}

.page-container .sidebar-menu .sidebar-main-menu li a:hover {
    background-color: <?php echo $color; ?>1a;
    color: <?php echo $color; ?>;
}

.footer-area {
    border-top: 1px solid <?php echo $color; ?>;
}

.footer-social li {
    background: <?php echo $color; ?>;
}

.custom-table thead tr {
    background: <?php echo $color; ?>;
}

.custom--card .card-header {
    background: <?php echo $color; ?>;
}


.form-control:disabled, .form-control[readonly] {
    background-color: <?php echo $color; ?>33;
}

.dropdown-menu__item {
    border-bottom: 1px solid <?php echo $color; ?>;
}

.dropdown-menu__item .dropdown-menu__icon {
    color: <?php echo $color; ?>;
}

.navbar-toggler span{
    color: <?php echo $color; ?>;
}

@media only screen and (max-width: 991px) {
  .page-container .sidebar-menu {
    border-bottom: 1px solid <?php echo $color; ?>;
  }
}
.page-container .sidebar-menu::before {
  border-bottom: 1px solid <?php echo $color; ?>;
}

.dashboard-item::before {
    background-color: <?php echo $color; ?>33;
}

.dashboard-item::after {
    background-color: <?php echo $color; ?>;
}

.dash-btn {
    background: <?php echo $color; ?>;
}

.dashboard-icon, .how-it-works-card .how-it-works-item::after, .footer-contact-list li .icon {
    color: <?php echo $color; ?>
}

@media (max-width: 991px) {
  .header-bottom-area .navbar-collapse {
    background-color: <?php echo $secondColor; ?> !important;
  }
}

.header-section.header-fixed {
    background-color: <?php echo $secondColor; ?> !important;
}

.how-it-works-icon, .footer-widget__title::after, .contact-info-item .contact-info-icon {
    background-color: <?php echo $color; ?>;
}

.pagination .page-item.disabled span, .pagination .page-item a, .pagination .page-item span {
    border-color: <?php echo $color; ?>;
}

.bg--base {
    background-color: <?php echo $color; ?> !important;
}