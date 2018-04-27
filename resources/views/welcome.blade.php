<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" id="app">
            <h1>
                Task Management
            </h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Create Task
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" v-model="name">
                                </div>
                                <div class="form-group">
                                    <label>Task</label>
                                    <input type="text" class="form-control" placeholder="Enter Task" v-model="task">
                                </div>
                                <div @click="createTodo()" class="btn btn-primary">Submit</div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Task List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Task</th>
                                            <th>Done</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="todo, index in todos" v-if="todo != null">
                                            <td>
                                                @{{ todo.name }}
                                            </td>
                                            <td>
                                                @{{ todo.task }}
                                            </td>
                                            <td>
                                                <input type="checkbox" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>

        <script>
            // Initialize Firebase
            var config = {
                apiKey: "{{ config('services.firebase.api_key') }}",
                authDomain: "{{ config('services.firebase.auth_domain') }}",
                databaseURL: "{{ config('services.firebase.database_url') }}",
                storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            };
            firebase.initializeApp(config);

            new Vue({
                el: '#app',

                data: {
                    task: '',
                    name: '',
                    todos: []
                },

                mounted: function() {
                    var self = this;
                    var randomstring = Math.random().toString(36).slice(-100);
                    console.log(randomstring)
                    // Initialize firebase realtime database.
                    firebase.database().ref('todos/').on('value', function(snapshot) {
                        // Everytime the Firebase data changes, update the todos array.
                        // self.$set('todos', snapshot.val());
                        self.todos = snapshot.val();
                        var values = snapshot.val(); 
                    });
                },



                methods: {

                    stringGenerator(len)
                    {
                        var text = " ";
                        var charset = "abcdefghijklmnopqrstuvwxyz0123456789";
                        for( var i=0; i < len; i++ )
                            text += charset.charAt(Math.floor(Math.random() * charset.length));
                        return text;
                    },


                    checkData: function(todo) {
                        console.log(todo)
                    },
                    /**
                     * Create a new todo and synchronize it with Firebase
                     */
                    createTodo: function() {
                        var self = this;
                        var number = self.stringGenerator(50);

                        firebase.database().ref('todos/' + number).set({
                            name: self.name,
                            task: self.task,
                        });
                        this.name = '';
                        this.task = '';
                    }
                }
            });
        </script>
    </body>
</html>
