# NogiFil

YouTubeチャンネル「乃木坂配信中」の動画を、推しでフィルタリング

## コンテナ起動

```sh
docker-compose up -d --build
```

## Laravel

プロジェクト作成（version 8.x）

```sh
docker-compose exec api composer create-project --prefer-dist laravel/laravel sample "8.*"
```

`localhost:80`にアクセスするとLaravelのウェルカムページが表示される

## React

### 開発用サーバー起動

プロジェクト作成

```sh
docker-compose exec front npx create-react-app . --template typescript
```

```sh
docker-compose exec front yarn start
```

`localhost:3000`にアクセスするとReactのウェルカムページが表示される

開発用サーバーの停止は`control + c`
