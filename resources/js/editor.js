import Rete,  { Control } from "rete";
import VueRenderPlugin from "rete-vue-render-plugin";
import ConnectionPlugin from "rete-connection-plugin";
import ContextMenuPlugin from "rete-context-menu-plugin";
import AreaPlugin from "rete-area-plugin";
import CommentPlugin from "rete-comment-plugin";
import HistoryPlugin from "rete-history-plugin";
import LifecyclePlugin from 'rete-lifecycle-plugin';
import ConnectionPathPlugin from 'rete-connection-path-plugin';
//import ConnectionMasteryPlugin  from 'rete-connection-mastery-plugin';


import VueMessageControl from "./MessageControl.vue";
import VueMessageRequestControl from "./MessageRequest.vue"
import ImageControl from "./ImageControl.vue"

let numSocket = new Rete.Socket("Number Value");
let strSocket = new Rete.Socket("String");
const anyTypeSocket = new Rete.Socket('Any type');
numSocket.combineWith(anyTypeSocket);


//------------ Normal Message Noeud Control (Apparence)
class msgControl extends Control {
	constructor(emitter, key, readonly = false, msg) {
		super(key);
		this.component = VueMessageControl;
		this.props = {
			initial: msg,
			emitter,
			ikey: key,
			type: "text",
			readonly,
			change: () => this.onChange()
		};
	}
	setValue(value) {
		const ctx = this.vueContext;
		ctx.value = value;
	}
	onChange() {}
}
//------------ Message avec Request Noeud Control (Apparence)
class msgRequstControl extends Control {
	constructor(emitter, key, readonly = false, msg) {
		super(key);
		this.component = VueMessageRequestControl;
		this.props = {
			initial: msg,
			emitter,
			ikey: key,
			type: "text",
			readonly,
			change: () => this.onChange()
		};
	}
	setValue(value) {
		const ctx = this.vueContext;
		ctx.value = value;
	}
	setKey(requestKey) {
		const ctx = this.vueContext;
		ctx.requestKey = requestKey;
	}
	onChange() {}
}
//------------ Message avec Image Noeud Control (Apparence)
class imgControl extends Control {
	constructor(emitter, key, readonly = false, url) {
		super(key);
		this.component = ImageControl;
		this.props = {
			initial: url,
			emitter,
			ikey: key,
			type: "image",
			readonly,
			change: () => this.onChange()
		};
	}
	setValue(value) {
		const ctx = this.vueContext;
		ctx.value = value;
	}
	onChange() {}
}

class MessageRequestComponent extends Rete.Component {
    constructor() {

	  super("Envoyer une demande");

      this.task = {
        outputs: { text: "output" }
      };
    }
  
    builder(node) {
	  var out = new Rete.Output("1", "", anyTypeSocket);
	  var inp = new Rete.Input("input1", "", anyTypeSocket, true);
	 
	  return node.addControl(new msgRequstControl(this.editor, "content", true, node.data.text))
				   .addOutput(out)
				   .addInput(inp)
				   .setOutPutData("1", {title: '', value: '', key : 'firstOUTPUT', order : 1});
	}
	
    worker(node, inputs, outputs) {
		// console.log(node.outputData);
      return { text: node.data.text };
	}

  }

class MessageComponent extends Rete.Component {
    constructor() {

	  super("Envoyer un message");

      this.task = {
        outputs: { text: "output" }
      };
    }
    builder(node) {
	  var out = new Rete.Output("1", "", anyTypeSocket);
	  var inp = new Rete.Input("input1", "", anyTypeSocket, true);
	 
	  return node.addControl(new msgControl(this.editor, "content", true, node.data.text))
				   .addOutput(out)
				   .addInput(inp)
				   .setOutPutData("1", {title: '', value: '', key : 'firstOUTPUT', order : 1});
	}
    worker(node, inputs, outputs) {
		// console.log(node.outputData);
      return { text: node.data.text };
	}
  }

  class FirstMessageComponent extends Rete.Component {
    constructor() {

	  super("Start");

      this.task = {
        outputs: { text: "output" }
      };
    }
    builder(node) {
	  var out = new Rete.Output("1", "", anyTypeSocket);
	//   var inp = new Rete.Input("input1", "", anyTypeSocket, true);
	 
	  return 	node.addOutput(out)
				//    .addInput(inp)
				   .setOutPutData("1", {title: '', value: '', key : 'firstOUTPUT', order : 1});
	}
    worker(node, inputs, outputs) {
	}
  }
  class ImageComponent extends Rete.Component {
    constructor() {

	  super("Envoyer une image");

      this.task = {
        outputs: { text: "output" }
      };
    }
    builder(node) {
	  var out = new Rete.Output("1", "", anyTypeSocket);
	  var inp = new Rete.Input("input1", "", anyTypeSocket, true);
	 
	  return node.addControl(new imgControl(this.editor, "content", true, node.data.text))
				   .addOutput(out)
				   .addInput(inp)
				   .setOutPutData("1", {title: '', value: '', key : 'firstOUTPUT', order : 1});
	}
    worker(node, inputs, outputs) {
		// console.log(node.outputData);
      return { text: node.data.text };
	}
  }




let nbNodes = 0;
let globalComponents = [];
let components;
let container;
let n1;
let editor;
let engine;

export async function createFlowEditor(conversation) {
	
	globalComponents = [];
	nbNodes = 0;
	const myNode = document.getElementById("rete");
	myNode.innerHTML = '';
	container = document.querySelector("#rete");
	components = [
		new MessageComponent(),
		new MessageRequestComponent(),
		new ImageComponent(),
		new FirstMessageComponent()
	];

	editor = new Rete.NodeEditor("demo@0.1.0", container);

	editor.use(ConnectionPlugin);
	editor.use(VueRenderPlugin);
	editor.use(AreaPlugin, {
		background: false,
		snap: false,
		scaleExtent: { min: 0.4, max: 0.7 },
		translateExtent: { width: 5000, height: 4000 }
	})
	// editor.use(CommentPlugin);
	editor.use(HistoryPlugin);
	editor.use(LifecyclePlugin);
	editor.use(ConnectionPathPlugin, {

		curve: ConnectionPathPlugin.curveBundle, // curve identifier
		options: { vertical: false, curvature: 0.19 }, // optional
		arrow: { color: 'grey', marker: 'M-1,-8 L-1,8 L10,0 z' }
		//  M-5,-10 L-5,10 L20,0 z
	});
	//editor.use(ConnectionMasteryPlugin);

	editor.use(ContextMenuPlugin, {
		searchBar: true,
		items: {
			"Dump JSON": () => {
				console.log(editor.toJSON());
			}
		},
		allocate(component) {
			return ["+ New"];
		},
		rename(component) {
			return component.name;
		}
	});
	engine = new Rete.Engine("demo@0.1.0");
	components.map(c => {
		editor.register(c);
		engine.register(c);
	});

	if(!conversation){
		let firstNode = await components[3].createNode({ text : 'FIRSTMESSAGE', title : 'Start Message', type : "Start", id: 1});
		firstNode.position = [500, 250];
		editor.addNode(firstNode);
		firstNode.update();
		globalComponents[firstNode.id] = firstNode;
		nbNodes++;
	}else{
		await createFirstNode(conversation);
		await createLinks(conversation);
	}
	editor.on(
		"process nodecreated noderemoved connectioncreated connectionremoved",
		async () => {
			console.log("processing...");
			await engine.abort();
			await engine.process(editor.toJSON());
		}
	);
	// engine.on('error', ({ message, data }) => {
	// 	console.log(message);
	// 	console.log(data);
	// });

	// editor.on('nodedraged', async (node) =>
	// {
	//     console.log('node dragged', node);
	//     let grid = 10;
	//     node.position[0] = Math.floor(node.position[0] / grid) * grid;
	//     node.position[1] = Math.floor(node.position[1] / grid) * grid;
	// });
	editor.on('zoom', ({ source }) => {
		return source !== 'dblclick';
	});
	
	setTimeout( () => {
		editor.view.resize();
		AreaPlugin.zoomAt(editor);
	}, 100)

	editor.trigger("process");

	}

// functions :

async function createFirstNode(conversation){
	if(conversation.nodes)
		Object.values(conversation.nodes).forEach(node => {
		if(node)
			{
				switch (node.data.type) {
					case 'Start':
						newFirstNode(node.id, node.position);
					break;
					case 'message':
						newNode(0, node.data, null, null, node.position, node.id);
					break;
					case 'request_message':
						newRequestMsgNode(1, node.data, node.position, node.id);
						break;
					case 'image':
						newImageNode(2, node.data, node.position, true, node.id);
						break;
					default:
						break;
				}
			}
	});
}
async function newFirstNode(node, position){

	nbNodes++;
	
	let newNode = await components[3].createNode({ text : 'FIRSTMESSAGE', title : 'Start Message', type : "Start", id : 1});
																									
	newNode.position = position;
	editor.addNode(newNode);
	newNode.update();
	globalComponents[node] = newNode;
	
	// document.getElementsByClassName("node"+newNode.data.id)[0].innerHTML = title;

}
async function createLinks(conversation){
	setTimeout(() => {
		if(conversation.nodes)
		Object.values(conversation.nodes).forEach(node => {
			if(node)
				node.outputs.forEach(output => {
					if(output){
						if(output.data.key != "firstOUTPUT"){
							addButton(node.id, output.data.title, output.data.value, output.data.key, output.data.order );
						}
						if (output.connections){
							setTimeout(() => {
								output.connections.forEach(connection => {
									if(connection){
										let key = output.data.key;
										if(output.data.key == "firstOUTPUT")
											key = 1+'';

											editor.connect(globalComponents[node.id].outputs.get(key), 
											globalComponents[connection.node].inputs.get(connection.input));	
									}

								});
							}, 50);
						}
					}
				});
		});
	}, 100);
}

let i = 2;
//------------- Ajout d'un nouvel bouton
export async function addButton(node, text, value = "", keyB = null, order = null){
	let msg = globalComponents[node];
	if(!keyB)
		keyB = msg.outputs.size +1;
	if(!order)
		order = keyB;
	var out = new Rete.Output(keyB, text, anyTypeSocket);
	await msg.addOutput(out);
	msg.setOutPutData(keyB, {title: text, value: value, key: keyB, order : order});
	msg.update();
	// editor.trigger("process");

	// console.log(editor.toJSON());
	i++;
}
//------------- Changement du nom d'un boutton
export async function changeName(node, key, newValue){
	let msg = globalComponents[node];
	// msg.changeOutput(key, newValue);
	msg.outputs.get(key).name = newValue;
	msg.outputs.get(key).data.title = newValue;
	msg.update();
	editor.trigger("process");
}
//------------- Changement du contenu d'un noeud
export async function changeContent(node, content){
	let msg = globalComponents[node];
	msg.data.text = "test";
	msg.controls.get('content').setValue(content);
	msg.update();
	editor.trigger("process");
}

//------------- Création d'une nouvelle noeud Message
export async function newNode(typeNode, newNodeConfig, options, deletedOptions, position = [500+ nbNodes *10, 250 + nbNodes *10], newId = -1){  
	nbNodes++;
	let newNode = await components[typeNode].createNode({ text : newNodeConfig.text, title : newNodeConfig.title, type : newNodeConfig.type, id : nbNodes});
																									
	newNode.position = position;
	editor.addNode(newNode);
	newNode.update();
	if(newId == -1){	
		newId = newNode.id;
	}
	globalComponents[newId] = newNode;
	
	if(options){
		await updateNode(newId, newNodeConfig, options, deletedOptions, true);
	}
	
	
	document.getElementsByClassName("node"+newNode.data.id)[0].innerHTML = newNodeConfig.title;
	
}

//------------- Création d'une nouvelle noeud Envoyer Image
export async function newImageNode(typeNode, newImageConfig, position = [500+ nbNodes *10, 250 + nbNodes *10], newImg = false, newId = -1, type = 'image'){  
	nbNodes++;
	let newNode = await components[typeNode].createNode({   text : newImageConfig.text, 
															title : newImageConfig.title, type: type, file: newImageConfig.file ,
															id : nbNodes});
	newNode.position = position;
	editor.addNode(newNode);
	if(newImg)
		newNode.controls.get('content').setValue('http://localhost:8000/images/users/uploads/'+newImageConfig.text);
	else
		newNode.controls.get('content').setValue(newImageConfig.file);
	newNode.update();
	if(newId == -1){	
		newId = newNode.id;
	}
	globalComponents[newId] = newNode;

	
	
	document.getElementsByClassName("node"+newNode.data.id)[0].innerHTML = newImageConfig.title;
}

//------------- Création d'une nouvelle Noeud de Request Message
export async function newRequestMsgNode(typeNode, newMessageRequestConfig, position = [500+ nbNodes *10, 250 + nbNodes *10], newId = -1, type = 'request_message'){  
	nbNodes++;
	let newNode = await components[typeNode].createNode({ text : newMessageRequestConfig.text,
																		title : newMessageRequestConfig.title,
																		type: type,
																		id : nbNodes,
																		keyRequest: newMessageRequestConfig.keyRequest,
																		typeRequest: newMessageRequestConfig.typeRequest,
																		validationMessage: newMessageRequestConfig.validationMessage
																		});

	newNode.position = position;
	editor.addNode(newNode);
	newNode.controls.get('content').setKey(newMessageRequestConfig.keyRequest);
	// globalComponents[idNode].data.keyRequest = newMessageRequestConfig.keyRequest;
	// globalComponents[idNode].data.typeRequest = newMessageRequestConfig.typeRequest;
	// globalComponents[idNode].data.validationMessage = newMessageRequestConfig.validationMessage;
	newNode.update();
	if(newId == -1){	
		newId = newNode.id;
	}
	globalComponents[newId] = newNode;
	
	document.getElementsByClassName("node"+newNode.data.id)[0].innerHTML = newMessageRequestConfig.title;
}
//------------- Mise à jour Noeud de Request Message
export async function updateRequestMsgNode(node, newMessageRequestConfig){  
	let msg = globalComponents[node];
	msg.controls.get('content').setKey(newMessageRequestConfig.keyRequest);
	msg.controls.get('content').setValue(newMessageRequestConfig.text);
	msg.data = newMessageRequestConfig;
	msg.update();
	document.getElementsByClassName("node"+msg.data.id)[0].innerHTML = newMessageRequestConfig.title;
}

//------------- Mise à jour d'un Noeud Message
export async function updateNode(node, data, options, deletedOptions, isNewNode){
	let msg = globalComponents[node];
	if(!isNewNode){
		msg.data = data;
		msg.controls.get('content').setValue(data.text);
	}

	//--- Créations des nouveaux boutons
	let hashmap = Object.fromEntries(msg.outputs);
	
	options.forEach(element => {
		var out = hashmap[element.key];
		if(out){
			hashmap[element.key].data.title = element.title;
			hashmap[element.key].data.value = element.value;
			hashmap[element.key].name = element.title;
			msg.outputs = new Map(Object.entries(hashmap));
		}else{
			addButton(node, element.title, element.value);
		}
	});
	msg.update();
	document.getElementsByClassName("node"+msg.data.id)[0].innerHTML = data.title;
	//--- Supprimer les boutons
	if(deletedOptions.length > 0)
		deletedOptions.forEach(element => {
			let out = msg.outputs.get(element.key+'');
			out.connections.slice().map(editor.removeConnection.bind(editor));

			msg.removeOutput(out);
			msg.update();
			// msg._alight.scan()
			editor.view.updateConnections({node: msg});
			console.log('DELETED');
		});
		
	//--- Trier les boutons 
	setTimeout(() => {
		let outputs = Object.fromEntries(msg.outputs);
		let myObject = new Map();
		myObject.set("1", outputs["1"]);
		var nb = 2;
		options.forEach(element => {

				var key = ''+element.key;
				myObject.set(key, outputs[element.key]);
				if(myObject.get(key)){
					myObject.get(key).data.order = nb;
					nb++;
				}
		});
		 msg.outputs = myObject;
		 msg.update();
	}, 50);
}
//------------- Constuire l'editeur Depuis Un DataObject
export async function buildConversation(conversation){

}

function searchKey(key, options){
	options.forEach(element => {
		if(key == element.key)
			return true;
	});
	return false;
}
export {globalComponents, editor, nbNodes}


