FROM mysql:8.0

RUN apt-get clean && \
    apt-get update && \
    apt-get install -y locales vim && \
    echo "ja_JP.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen ja_JP.UTF-8

ENV LANG ja_JP.UTF-8
ENV LANGUAGE ja_JP:en  
ENV LC_ALL ja_JP.UTF-8
ENV TZ=UTC

COPY my.cnf /etc/my.cnf