@component('mail::message')
# Buna ziua,

<p class="sub-title">
    Acesta este un email de notificare, care confirma acceptul Utilizatorului cu
    politica Cookie si cu faptul ca este de acord sa fie contactat prin internediul
    Chatului si VideoChatului instalate pe site-ul www.docrom.info.
</p>

@component('mail::subcopy')

<h3>Datele Utilizatorului:</h3>

@component('mail::table')
    <table class="customize-table">
        <tr>
            <td class="td-right">Cookie ID: </td>
            <td>{{ $details['cookieID'] ?? '---' }}</td>
        </tr>
        <tr>
            <td class="td-right">Numele Utilizatorului: </td>
            <td>{{ $details['name'] ?? 'nu a fost furnizat de User' }}</td>
        </tr>
        <tr>
            <td class="td-right">Data si ora cind Utilizatorul a dat acceptul cu politica Cookie: </td>
            <td>{{ Carbon\Carbon::now() }}</td>
        </tr>
        <tr>
            <td class="td-right">Device-ul Utilizatorului: </td>
            <td>{{ $details['device'] ?? 'nu a fost depistat' }}</td>
        </tr>
        <tr>
            <td class="td-right">Browser-ul Utilizatorului: </td>
            <td>{{ $details['browser'] ?? 'nu a fost depistat' }}</td>
        </tr>
    </table>
@endcomponent
@endcomponent

@component('mail::footer')
    Acesta este un mesaj informativ, la care nu este necesar de facut Reply. <br>
    Echipa tehnica Docrom
@endcomponent

@endcomponent
