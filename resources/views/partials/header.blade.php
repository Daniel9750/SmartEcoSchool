<header>
    <div id="institution">
        <h1>Smart<span>Eco</span>School</h1>
    </div>
    <nav>
        <ul>
            <li>
                <a href="{{ route('pages.annual.pie') }}">
                    <img src="{{ asset('assets/images/icons/pie.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.annual.radar') }}">
                    <img src="{{ asset('assets/images/icons/radar.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.monthly.bar') }}">
                    <img src="{{ asset('assets/images/icons/bar.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.monthly.line') }}">
                    <img src="{{ asset('assets/images/icons/line.png') }}" />
                </a>
            </li>
        </ul>
    </nav>
    <div id="control-panel">
        @yield('')
    </div>
</header>
