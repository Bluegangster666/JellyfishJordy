class Timer {
	constructor(callback, time) {
		this.time = time;
		this.callback = callback;
	}

	static async wait(time) {
		await new Promise((res) => setTimeout(res, time * 1000));
	}

	start() {
		const timer = () => {
			setTimeout(() => {
				if (this.time < 0) return;
				this.callback(this.time);
				this.time--;
				timer();
			}, 1000);
		};

		timer();
	}
}

class AudioManager {
	play(src, options) {
		const audio = Object.assign(new Audio(src), options);
		audio.play();
	}
}

class Game {
	constructor() {
		this.timeoutCache = [];
		this.gameObjectCache = new Set();
		this.currentTime = 0;
		this.points = 0;
		this.coins = 0;
		this.level = 0;
		this.hasStarted = false;
		this.isPaused = false;
		this.isActive = false;
	}

	random(min, max) {
		return Math.floor(Math.random() * (max - min + 1) + min);
	}
}

class Player {
	constructor({ x, y }) {
		this.x = x;
		this.y = y;
		this.keyboardInputCache = new Set();
	}

	get keyboardInput() {
		let input;
		for (input of this.keyboardInputCache);
		return input;
	}

	updateMovement() {
		document.getElementById("character").style.transform = `translate3d(${this.x * 10}px, ${this.y * 10}px, 0)`;
	}

	startControls() {
		switch (this.keyboardInput) {
			case "a":
				this.y <= 0 ? (this.y = 0) : (this.y -= 1);
				this.updateMovement();
				break;
			case "d":
				this.y >= 45 ? (this.y = 45) : (this.y += 1);
				this.updateMovement();
		}
	}
}

class GameObject {
	constructor({ x, y, height, width, element, type, velocity }) {
		this.type = type;
		this.element = element;
		this.velocity = velocity;
		this.x = x;
		this.y = y;
		this.height = height;
		this.width = width;
	}

	onCollision(object, callback) {
		if (
			object.x > this.x - 5 &&
			object.x < this.x + this.width &&
			object.y > this.y - 4 &&
			object.y < this.y + this.height - 2
		) {
			callback();
		}
	}
}

const audio = new AudioManager();
const game = new Game();
const player = new Player({ x: 15, y: 22.5 });

function spawnObstacles() {
	const wall = document.createElement("div");
	const height = game.random(3, 5) * 5;
	wall.style.height = `${height * 10}px`;
	wall.style.display = "none";
	wall.classList.add("obstacle");
	document.getElementById("game-canvas").appendChild(wall);

	const wallObject = new GameObject({
		element: wall,
		x: 150,
		y: game.random(-1, 7) * 5,
		height: height,
		width: 5,
	});

	game.gameObjectCache.add(wallObject, wallObject);

	if (!game.hasStarted && game.isPaused) return;

	const timeout = setTimeout(spawnObstacles, 900);
	game.timeoutCache.push(timeout);
}

function spawnCoins() {
	const coin = document.createElement("div");
	coin.classList.add("coin");
	coin.style.display = "none";
	document.getElementById("game-canvas").appendChild(coin);

	const coinObject = new GameObject({
		element: coin,
		type: "coin",
		velocity: game.random(1, 3) / 15 + game.level * 0.1,
		x: 150,
		y: game.random(1, 9) * 5,
		height: 5,
		width: 5,
	});

	game.gameObjectCache.add(coinObject, coinObject);

	if (!game.hasStarted && game.isPaused) return;

	const timeout = setTimeout(spawnCoins, game.random(3, 4) * 1000);
	game.timeoutCache.push(timeout);
}

async function countdown(time) {
	const text = document.getElementById("text");
	text.innerText = time ? time : "Start!";

	if (time === 0) {
		await Timer.wait(1);
		game.hasStarted = true;
		text.style.opacity = 0;
		spawnObstacles();
		spawnCoins();
	}
}

function start() {
	audio.play("./sounds/bgm.mp3", { volume: 0.1, loop: true });

	new Timer(countdown, 5).start();

	const level = document.getElementById("level");
	const score = document.getElementById("score");
	const text = document.getElementById("text");
	const saveScore = document.getElementById("saveScore");
	const progressBar = document.getElementById("progress-bar");

	player.updateMovement();

	const loop = (time) => {
		let TotalPoints = 0 + game.points + game.coins;
		level.innerText = game.level;
		score.innerText = TotalPoints;

		setTimeout(() => {
			game.level = Math.floor(game.points / 300) + 1;

			if (game.points / 300 + 1 === game.level && game.level > 1) {
				if (time > game.currentTime + 2000) {
					audio.play("./sounds/levelnext.mp3", { volume: 0.1 });
					game.currentTime = time;
				}
			}

			for (const object of game.gameObjectCache) {
				const progress = ((game.points - 300 * (game.level - 1)) / 300) * 100;
				progressBar.style.background = `linear-gradient(to right, #e1e1e1 ${progress}%, #f1f1f1 0%, #f1f1f1 0%)`;

				object.element.style.display = "unset";
				object.x -= object?.velocity || 0.7 + game.level * 0.1;
				object.element.style.transform = `translate3d(${object.x * 10}px, ${object.y * 10}px, 0)`;

				switch (object.type) {
					case "coin":
						object.onCollision(player, () => {
							object.element.remove();
							game.gameObjectCache.delete(object);

							audio.play("./sounds/coin.mp3", { volume: 0.1 });

							game.coins += 10;
						});
						break;
					default:
						object.onCollision(player, () => {
							if (game.isActive === true) {
								game.isActive = false;

								audio.play("./sounds/death.mp3", { volume: 0.1 });

								game.timeoutCache.forEach((timeout) => clearTimeout(timeout));

								document.getElementById("game-canvas").toggleAttribute("inactive");
								text.style.opacity = 100;
								text.innerText = "CTRL + R to restart";

								saveScore.innerHTML = "<button id='BigBoiButton'>Score opslaan</button>";
								
								$("#BigBoiButton").click(function(){
									location.href = 'ScoreVerwerk.php?score=' + TotalPoints;
								});
							}
						});
				}

				if (object.x < -5 && game.hasStarted) {
					object.element.remove();
					game.gameObjectCache.delete(object);

					game.points += 5;

					level.innerText = game.level;
					score.innerText = game.points + game.coins;
				}
			}

			if (game.hasStarted) {
				player.startControls();
			}

			if (game.isActive && !game.isPaused) {
				requestAnimationFrame(loop);
			}
		}, 1000 / 60);
	};

	game.isActive = true;

	loop();
}

window.addEventListener("load", () => {
	document.getElementById("btn-play").addEventListener("click", () => {
		document.getElementById("page-main").toggleAttribute("hide");
		document.getElementById("game").removeAttribute("hide");
		start();
	});
});

window.addEventListener("keydown", (event) => player.keyboardInputCache.add(event.key));
window.addEventListener("keyup", (event) => player.keyboardInputCache.delete(event.key));

