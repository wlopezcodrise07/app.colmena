<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <!-- Sidenav Link (Alerts)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <!-- Sidenav Link (Messages)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <div class="sidenav-menu-heading">Menús</div>

                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                    <div class="nav-link-icon"><i class="fas fa-tools"></i></div>
                    Mantenimiento
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMantenimiento" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{route('mantenimiento.clientes.index')}}">Clientes</a>
                        <a class="nav-link" href="{{route('mantenimiento.producto_cliente.index')}}">Productos de Clientes</a>
                        <a class="nav-link" href="{{route('mantenimiento.forma_pago.index')}}">Formas de Pago</a>
                        <a class="nav-link" href="{{route('mantenimiento.accion.index')}}">Acciones</a>
                        <a class="nav-link" href="{{route('mantenimiento.influencer.index')}}">Influencers</a>
                    </nav>
                </div>


            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Ha iniciado sesión como:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->nombre.' '.Auth::user()->apepat.' '.Auth::user()->apemat }}</div>
            </div>
        </div>
    </nav>
</div>
