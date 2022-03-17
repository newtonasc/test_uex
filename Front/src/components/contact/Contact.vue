<template>
  	<div>
    	<div class="card-list container-fluid">
			<b-row>
				<b-col>
					<label for="contactType">Tipo de contato</label>
				</b-col>
			</b-row>
			<b-row>
				<b-col>	
					<b-form-select id="contactType" v-model="selectedContactType" :options="listContactTypes" :disabled="loadingContactTypeList"></b-form-select>
				</b-col>
			</b-row>
			<b-row>
				<b-col>
					<label for="search">Buscar</label>
				</b-col>
			</b-row>
			<b-row>
				<b-col>
					<b-form-input id="search" placeholder="Nome, CPF, Telefone"></b-form-input>
				</b-col>
			</b-row>
			<b-row>
				<b-col> <b-button variant="link" @click="add()"><b-icon icon="plus"></b-icon> Novo contato</b-button></b-col>
			</b-row>
			<b-row>
				<b-col>
					<div class="content-contacts">
						<template v-if="loadingContactList">
							<div class="text-center">
								<b-icon icon="circle-fill" animation="throb" class="text-warning" font-scale="2"></b-icon>
							</div>
						</template>
						<template v-else>
							<template v-if="!listContacts">
								<div class="text-muted">Nenhum contato cadastrado.</div>
							</template>
							<template v-else>
							<ul v-for="(contact, index) in listContacts" :key="index">  
								<li :id="`line_${contact.id}`" :class="['text-info', 'selectable', contact.id == activeId ? 'selected' : '', contact.id == checkedId ? 'selected' : '']" @mouseover="showPin(contact.id)" @mouseout="hidePin(contact.id)">
									<b-row>
										<b-col cols="9" @click="selectContact(contact.id)" @dblclick="edit(contact)">{{ contact.name }}</b-col>
										<b-col cols="3" class="text-right"><b-button variant="link" size="sm" @click="edit(contact)"><b-icon icon="pencil"></b-icon></b-button></b-col>
									</b-row>
									<b-row>
										<b-col cols="9" @click="selectContact(contact.id)" @dblclick="edit(contact)"><small class="text-muted">{{ contact.cpf }}</small></b-col>
										<b-col cols="3" class="text-right"><b-button variant="link" size="sm" @click="modalDelete(contact)"><b-icon icon="trash"></b-icon></b-button></b-col>
									</b-row>
								</li>
							</ul>
							</template>
						</template>
					</div>
				</b-col>
			</b-row>					
		</div>
		<b-modal :no-close-on-esc="true" :no-close-on-backdrop="true" id="modalRemove" hide-footer centered size="xs">
			<template #modal-title>
				Excluír contato
			</template>
			<div class="modal-question">
				<span class="text-muted"><span class="text-danger">Confirma a exclusão do contato</span> <strong>{{ removeContact.name }}</strong>?</span> 
			</div>
			<b-row>
				<b-col class="text-right">
					<b-button class="right" size="sm" variant="info" @click="remove(removeContact.id)">Confirmar</b-button>
					<b-button class="right" size="sm" variant="link" @click="$bvModal.hide('modalRemove')">Cancelar</b-button>
				</b-col>
			</b-row>
		</b-modal>
  	</div>
</template>
<script src="./Contact.js"></script>
<style lang="css" src="./Contact.css" scoped></style>