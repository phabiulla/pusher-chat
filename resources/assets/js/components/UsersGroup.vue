<template>
    <div class="panel panel-default">
        <div class="panel-heading col-md-12">
            <div class="contact-profile" style="background: #fff!important;">
                <div id="profile">
                    <div class="wrap">
                        <img id="profile-img" v-bind:src="loggedUser.avatar_url" v-bind:class="loggedUser.status" alt=""
                             @click.prevent="statusOptions=!statusOptions" />
                        <p>{{ loggedUser.nick }}</p>
                        <div id="status-options" v-bind:class="{'active': statusOptions === true}">
                            <ul>
                                <li v-bind:id="s.id" v-for="s in listStatus" v-bind:class="{'active': loggedUser.status === s.status}"
                                    @click.prevent="changeStatusOfUser(s.status)" >
                                    <span class="status-circle"></span>
                                    <p>{{s.label}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--<button type="submit" @click.prevent="createGroup" class="btn btn-primary col-md-offset-9">-->
                    <!--+ Grupo-->
                <!--</button>-->
            </div>
        </div>
        <div class="panel-body users-panel" style="height: calc(100vh - 200px); background:#f3f3f3;">
            <ul class="users">
                <li class="contact" v-bind:class="{'active': u.name}" v-for="u in usersListChat" :value="u.id" @click.prevent="openConversation(null, u)">
                    <div class="wrap">
                        <span class="contact-status" v-bind:class="{'online':u.status === 'online', 'busy':u.status === 'busy',
                         'away':u.status === 'away', 'offline':u.status === 'offline'}" ></span>
                        <img v-bind:src="u.avatar_url" alt="User Avatar" class="img-circle" />
                        <div class="meta">
                            <p class="name">{{u.nick}}</p>
                            <p class="preview">{{u.slogan}}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="panel-footer text-center">

        </div>
    </div>
</template>

<script>
    export default {
        props: ['initialUsers', 'user'],

        data() {
            return {
                usersListChat: this.initialUsers,
                usersList: this.usersListChat,
                loggedUser: this.user,
                name: '',
                users: [],
                statusOptions: false,
                listStatus: [
                    {label:'Online', status: 'online', id: 'status-online'},
                    {label:'Away', status: 'away', id: 'status-away'},
                    {label:'Busy', status: 'busy', id: 'status-busy'},
                    {label:'Offline', status: 'offline', id: 'status-offline'}
                ]
            }
        },

        methods: {
            updateUser(user){
                var self = this;

                this.usersList = this.usersListChat;
                this.usersList.forEach(function (element, index){
                    if(element.id === user.id) {
                        self.usersListChat[index].status = user.status;
                    }
                });

                this.$set(this.usersListChat, self.usersListChat);
            },
            openConversation(group, receiver) {
                Bus.$emit('conversationChange', group, receiver);
            },
            createGroup() {
                axios.post('/groups', {name: this.name, users: this.users})
                .then((response) => {
                    this.name = '';
                    this.users = [];
                    Bus.$emit('groupCreated', response.data);
                });
            },
            updateLoggedUser(newUser) {
                this.loggedUser = newUser;
            },
            changeStatusOfUser(newStatus) {
                axios.put('/user/'+this.loggedUser.id+'/change-status', {status: newStatus})
                    .then((response) => {
                        this.statusOptions = false;
                        this.updateLoggedUser(response.data);
                    });
            },
            listenForUserUpdate() {
                Echo.private('updated')
                    .listen('UserUpdated', (e) => {
                        console.log("listen user-groups");
                        this.updateUser(e.user)
                    });
            }
        },

        mounted() {
            this.listenForUserUpdate();
        }
    }
</script>
