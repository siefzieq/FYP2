@extends('layouts.app')
<style>

    form{
        padding-top: 50px;
        padding-left: 40px;
    }

    input, textarea, select{
        background-color: #F7F7F7 !important;
    }

    .btn.btn-outline {
        border-color: #2D6C2B;
        color: #2D6C2B;
    }

    .btn.btn-outline:hover {
        background-color: #2D6C2B;
        color: #ffffff; /* Change text color when hovered */
    }


</style>

@section('title', 'Add Flat Inventory')
@section('caption', 'Add Flat Inventory')
@section('content')
    <div style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); position: relative; margin-top: 3%; left: -0.5%; width: 96%; height: 70%; overflow: hidden;">
        <div style="height: calc(100% - 20px); overflow-y: auto;">

            <form method="POST" action="{{route('flatInventory.update',$flatProgress)}}"  style="width: 100%;">
                @csrf
                @method('PATCH')
                <label class="form-label">Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="DD/MM/YYYY"  style="width: 95%;" value="{{$flatProgress->start_date}}"><br>

                <label class="form-label">Flat ID</label>
                <select class="form-select form-control" id="flat_id" name="flat_id" style="width: 95%;">
                    <option selected disabled>Choose the flat</option>
                    @foreach($flats as $f)
                        <option value="{{$f->id}}" {{ $flatProgress->flat_id==$f->id ? 'selected' : '' }}>{{$f->name}}</option>
                    @endforeach
                </select><br>

                <label class="form-label">Planting Type</label>
                <select class="form-select form-control" id="planting_type" name="planting_type" style="width: 95%;">
                    <option selected disabled>Choose the plant category</option>
                    <option value="fertigation" {{ $flatProgress->planting_type=='fertigation' ? 'selected' : '' }}>Fertigation</option>
                    <option value="conventional" {{ $flatProgress->planting_type=='conventional' ? 'selected' : '' }}>Conventional</option>
                    <option value="aquaponic" {{ $flatProgress->planting_type=='aquaponic' ? 'selected' : '' }}>Aquaponic</option>
                </select><br>

                <label class="form-label">Plant</label>
                <select class="form-select form-control" id="plantation_id" name="plantation_id" style="width: 95%;">
                    <option selected disabled>Choose the associated plants</option>
                    @foreach($plantation as $p)
                        <option value="{{$p->id}}" {{ $flatProgress->plantation_id==$p->id ? 'selected' : '' }}>{{$p->plant->name}}</option>
                    @endforeach


                </select><br>

                <label class="form-label">Area planted (m<sup>2</sup>)</label><br>
                <input type="number" class="form-control" id="area_planted" name="area_planted" style="width: 95%;" placeholder="Enter area planted"  min="1.0" step="0.01" value="{{$flatProgress->area_planted}}"><br>

                <label class="form-label">Stage</label>
                <select class="form-select form-control" id="stage" name="stage" style="width: 95%;">
                    <option selected disabled>Choose the progress stage</option>
                    <option value="seeding" {{ $flatProgress->stage=='seeding' ? 'selected' : '' }}>Seeding</option>
                    <option value="harvesting" {{ $flatProgress->stage=='harvesting' ? 'selected' : '' }}>Harvesting</option>
                    <option value="completed" {{ $flatProgress->stage=='completed' ? 'selected' : '' }}>Completed</option>
                </select><br>

                <div class="d-flex justify-content-end gap-2" style="padding-top: 30px; padding-right: 60px">
                    <a href="{{route('flatInventory.index')}}" role="button" type="reset" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn text-white" style="background-color:#2D6C2B; border-radius: 8px; height: 38px; width: 80px;">Add</button>
                </div>
            </form>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const plantTypeSelect = document.getElementById('planting_type');
            const plantSelect = document.getElementById('plantation_id');
            const allPlants = @json($plantationData);

            plantTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;

                // Access the specific array for the selected planting type directly
                const plantsForType = allPlants[selectedType] || [];

                // Clear existing options in plant select
                plantSelect.innerHTML = '<option selected disabled>Choose the associated plants</option>';

                // Append new options based on selected planting type
                plantsForType.forEach(plant => {
                    const option = new Option(plant.plant.name, plant.id);
                    plantSelect.appendChild(option);
                });
            });
        });


    </script>

@endsection