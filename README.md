# NogiFil

[乃木坂配信中](https://www.youtube.com/c/nogizakahaishinchu)というYouTubeチャンネルの動画から、検索したメンバーが出演している動画をフィルタリングして表示するアプリケーション。

<img width="80%" src="https://github.com/user-attachments/assets/b59793d6-008b-45c6-8b68-bd21094b98cf" />

<img width="80%" src="https://user-images.githubusercontent.com/57553474/166925938-796257fc-242d-4988-a3c9-4196a7bf61ba.png" />

## Technology

- TypeScript
- React
- PHP
- Laravel

Infrastructure

- Vercel
- heroku

![struct](https://user-images.githubusercontent.com/57553474/167066191-358b1047-0736-4e8e-bd41-a9d8e611ab67.png)

## Get Started（Local）

### Set YouTube API Key

```sh
cp api/.env.example api/.env
```

On Google Cloud, obtain an API key from YouTube Data API v3 and set it in the `.env` file.

### Set up the environment

```sh
docker compose up -d --build
```
