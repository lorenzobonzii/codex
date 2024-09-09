import { Component, Input, ViewChild, ViewEncapsulation } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { YouTubePlayer } from '@angular/youtube-player';
import { map, Observable } from 'rxjs';

@Component({
  selector: 'app-watch',
  standalone: true,
  imports: [YouTubePlayer],
  encapsulation: ViewEncapsulation.None,
  templateUrl: './watch.component.html',
  styleUrl: './watch.component.scss'
})
export class WatchComponent {
  constructor(private route: ActivatedRoute) { }
  @ViewChild('player') player!: YouTubePlayer;
  videoId$!: Observable<string>;
  videoId!: string;
  width: number | "100%" = "100%";
  height: number | "100%" = "100%";

  ngOnInit(): void {
    this.rootElem = document.getElementsByTagName('iframe')[0];
    this.videoId$ = this.route.queryParamMap.pipe(
      map((params: ParamMap) => params.get('videoId') ?? ''),
    );
    this.videoId$.subscribe(videoId => {
      this.videoId = videoId;
      this.initScriptIFrame();
      this.maximizeFullscreen();
    });
  }

  playerVars = {
    autoHide: 1,
    controls: 1,
    showinfo: 0,
    modestbranding: 1,
    disablekb: 0,
    rel: 0,
    fs: 0,
    playsinline: 1,
    loop: 0,
    mute: 0,
    autoplay: 1,
    allowfullscreen: 1,
    frameBorder: 0,
    cc_load_policy: 3,
    iv_load_policy: 3,
    origin: location.href,
  };

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  rootElem: HTMLElement | any;
  isMaximixe = true;
  showSpeakerUpIcon = true;
  showPlayIcon = true;
  valuePlayerBar = 0;
  maxValueRange!: number;
  isLoading: boolean = false;
  isPlaying: boolean = false;

  initScriptIFrame() {
    const tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    document.body.appendChild(tag);
  }

  onReadyPlayer() {
    //this.player.youtubeContainer.nativeElement.style.display = 'none';
    this.showPlayIcon = !this.showPlayIcon;
    this.isLoading = false;
  }

  onApiChange() {
    // Update the controls on load
    this.updateProgressBar();

    this.maxValueRange = this.player.getDuration();

    setInterval(() => {
      this.updateProgressBar();
    }, 1000);
  }

  updateProgressBar() {
    this.valuePlayerBar =
      (this.player.getCurrentTime() / this.player.getDuration()) * 100;
  }

  formatTime(time: number) {
    time = Math.round(time);

    const minutes = Math.floor(time / 60);
    let seconds = time - minutes * 60;

    seconds = seconds < 10 ? Number('0' + seconds) : seconds;

    return minutes + ':' + seconds;
  }

  onChangeThumb(event: Event): void {
    // Cast event.target to HTMLInputElement
    const target = event.target as HTMLInputElement;
    // Calculate the new time for the video.
    // new time in seconds = total duration in seconds * ( value of range input / 100 )
    const newTime =
      this.player.getDuration() * (parseFloat(target.value) / 100);

    // Skip video to new time.
    this.player.seekTo(newTime, true);
  }


  changeStatusSpeaker() {
    this.showSpeakerUpIcon = !this.showSpeakerUpIcon;

    this.changeMuteState();
  }

  changeMuteState() {
    if (this.player.isMuted()) {
      this.player.unMute();
    } else {
      this.player.mute();
    }
  }

  //https://developers.google.com/youtube/iframe_api_reference#getPlayerState
  changeStatusPlay() {
    if (this.player.getPlayerState() === 1) {
      this.player.pauseVideo();
    } else {
      this.player.playVideo();
    }

    this.onReadyPlayer();
  }

  onStateChange() {
    if (this.player.getPlayerState() === 1) {
      this.isPlaying = true;
    }
    else {
      this.isPlaying = false;
    }
  }

  goAhead10sNext() {
    this.player.seekTo(this.player.getCurrentTime() + 10, true);
  }

  comeBack10sPrev() {
    this.player.seekTo(this.player.getCurrentTime() - 10, true);
  }

  maximizeFullscreen() {
    if (this.rootElem.requestFullscreen) {
      this.rootElem.requestFullscreen();
    } else if (this.rootElem.mozRequestFullScreen) {
      /* Firefox */
      this.rootElem.mozRequestFullScreen();
    } else if (this.rootElem.webkitRequestFullscreen) {
      /* Chrome, Safari and Opera */
      this.rootElem.webkitRequestFullscreen();
    } else if (this.rootElem.msRequestFullscreen) {
      /* IE/Edge */
      this.rootElem.msRequestFullscreen();
    }
    this.isMaximixe = !this.isMaximixe;
  }

  minimizeFullscreen() {
    if (this.rootElem.exitFullscreen) {
      this.rootElem.exitFullscreen();
    } else if (this.rootElem.mozCancelFullScreen) {
      /* Firefox */
      this.rootElem.mozCancelFullScreen();
    } else if (this.rootElem.webkitExitFullscreen) {
      /* Chrome, Safari and Opera */
      this.rootElem.webkitExitFullscreen();
    } else if (this.rootElem.msExitFullscreen) {
      /* IE/Edge */
      this.rootElem.msExitFullscreen();
    }
    this.isMaximixe = !this.isMaximixe;
  }
}
