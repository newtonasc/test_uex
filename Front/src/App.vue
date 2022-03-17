<template>
  	<div id="app">
    	<router-view/>
		<vue-snotify></vue-snotify>
  	</div>
</template>

<script>
export default {
  	name: 'App'
}
</script>
<style scoped>
#app {
	height: calc(100vh - 0px);
    width: calc(100vw - 2px);
	background-color: #444630; 
	overflow: hidden;
}
</style>