package com.da.qlnhahang.service;

import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;

import androidx.annotation.NonNull;
import androidx.core.app.NotificationCompat;

import com.da.qlnhahang.R;
import com.da.qlnhahang.ui.MainActivity;
import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

public class FCMService extends FirebaseMessagingService {
    @Override
    public void onMessageReceived(@NonNull RemoteMessage message) {
        super.onMessageReceived(message);
        NotificationManager manager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        String channelId = "ORDER";
        NotificationChannel channel = new NotificationChannel(
                channelId,
                channelId,
                NotificationManager.IMPORTANCE_HIGH
        );
        manager.createNotificationChannel(channel);
        PendingIntent intent = PendingIntent.getActivity(
                this,
                0,
                new Intent(this, MainActivity.class),
                PendingIntent.FLAG_UPDATE_CURRENT
        );
        Notification compat = new NotificationCompat.Builder(this, channelId)
                .setSmallIcon(R.mipmap.ic_launcher)
                .setContentText(message.getNotification().getTitle())
                .setContentText(message.getNotification().getBody())
                .setContentIntent(intent)
                .build();
        manager.notify(1234, compat);
    }
}
