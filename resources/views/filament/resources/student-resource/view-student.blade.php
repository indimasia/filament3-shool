<x-filament-panels::page>
    @if ($this->hasInfolist())
        {{ $this->infolist }}
        {{-- <div id="qrcode" style="width:100px; height:100px" class="mt-2"></div> --}}
    @else
        {{ $this->form }}
    @endif
 
    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers
            :active-manager="$activeRelationManager"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        />
    @endif
</x-filament-panels::page>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
window.addEventListener("load", () => {
    var qrc = new QRCode(document.getElementById("qrcode"), "Testing");
});
</script> --}}