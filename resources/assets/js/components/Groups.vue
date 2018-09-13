<template>
    <div>
        <conversation :user="user"></conversation>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {}
        },

        mounted() {
            Bus.$on('groupCreated', (group) => {
                this.groups.push(group);
            });

            this.listenForNewGroups();
        },

        methods: {

            listenForNewGroups() {
                Echo.private('users.' + this.user.id)
                    .listen('GroupCreated', (e) => {
                        this.groups.push(e.group);
                    });
            }
        }
    }
</script>
