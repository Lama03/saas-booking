<x-booking::layouts.master>
    <h2>Create Booking</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <label for="service_id">Service:</label>
        <select name="service_id" required>
            @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>

        <label for="start_time">Start Time:</label>
        <input type="datetime-local" name="start_time" required>

        <label for="end_time">End Time:</label>
        <input type="datetime-local" name="end_time" required>

        <button type="submit">Book</button>
    </form>

</x-booking::layouts.master>
