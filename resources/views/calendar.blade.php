<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Event App</title>
</head>
<body class="bg-light">
<main id="app">
    <div class="container-fluid mt-3">
        <div class="card shadow rounded">
            <div class="card-header fw-bolder">
                Calendar
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <form @submit.prevent="submit" class="mb-sm-4">
                            <div class="mb-3">
                                <label for="event" class="form-label">Event</label>
                                <input type="text" class="form-control" name="event" id="event" placeholder="Enter event" required>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3 ">
                                        <label for="from" class="form-label">From</label>
                                        <input type="date" class="form-control" name="from" id="from" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="to" class="form-label">To</label>
                                        <input type="date" class="form-control" name="to" id="to" required>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-check-inline" v-for="(day,i) in days" :key="i">
                                    <input class="form-check-input" type="checkbox" name="eventDays[]" :value="i" :id="day">
                                    <label class="form-check-label" :for="day">@{{day.substring(0,3)}}</label>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-md-2 col-sm-12 mt-3">
                                <button type="submit" class="btn btn-primary" :disabled="isProcessing" v-html="isProcessing ? loaderHtml : 'Save'"></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-8" v-if="paginatedDates.length > 0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item fw-bold fs-3">@{{calendarTitle}}</li>
                            <li class="list-group-item d-flex flex-row"
                                :class="{'list-group-item-success': date.event}"
                                v-for="date in paginatedDates"
                            ><div class="w-25">@{{date.label}}</div><div>@{{date.event}}</div></li>
                        </ul>

                        <nav aria-label="Events page navigation">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item" :class="{'disabled': pagination.page === 1 }"><a class="page-link" href="#" @click="pagination.page-=1">Previous</a></li>
                                <li class="page-item" :class="{'disabled': pagination.page === maxPage}"><a class="page-link" href="#" @click="pagination.page+=1">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- production version, optimized for size and speed -->
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
