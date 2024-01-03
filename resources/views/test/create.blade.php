<form action="{{ route('test.store') }}" method="post">
    @csrf
    好きな動物は？ : 
    <select name="animal_id" id="animal_id">
        <option value="">-</option>
        @foreach($animals as $animal)
            <option value="{{ $animal['id'] }}">{{ $animal['name'] }}</option>
        @endforeach
    </select>
    <button>送信</button>
</form>