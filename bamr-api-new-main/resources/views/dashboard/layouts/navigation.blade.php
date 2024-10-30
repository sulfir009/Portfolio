<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('main.index') }}">Main</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('country.index') }}">Countries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business-number.index') }}">Business numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('campaign-code.index') }}">Campaign codes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('keyword.index') }}">Keywords</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('service.index') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('affiliates.index') }}">Affiliates</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
