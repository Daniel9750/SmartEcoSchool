<header>
    <div id="institution">
        <h1>IES El Rincón</h1>
    </div>
    <nav>
        <ul>
            <li>
                <a href="{{ route('pages.annual.pie') }}">
                    <img src="{{ asset('assets/images/icons/table.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.annual.radar') }}">
                    <img src="{{ asset('assets/images/icons/statistics.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.monthly.bar') }}">
                    <img src="{{ asset('assets/images/icons/table.png') }}" />
                </a>
            </li>
            <li>
                <a href="{{ route('pages.monthly.line') }}">
                    <img src="{{ asset('assets/images/icons/table.png') }}" />
                </a>
            </li>
        </ul>
    </nav>
    <div id="control-panel">
        @yield('disconnect')
    </div>
</header>
