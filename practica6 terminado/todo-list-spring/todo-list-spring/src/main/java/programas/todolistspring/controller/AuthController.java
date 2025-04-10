package programas.todolistspring.controller;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import programas.todolistspring.dto.AuthResponse;
import programas.todolistspring.dto.LoginRequest;
import programas.todolistspring.dto.RegisterRequest;
import programas.todolistspring.repository.TokenBlacklistRepository;
import programas.todolistspring.service.AuthService;


@RestController
@RequestMapping("/api/auth")

public class AuthController {

    private final AuthService authenticationService;
    private final TokenBlacklistRepository tokenBlacklistRepository;

    public AuthController(AuthService authenticationService, TokenBlacklistRepository tokenBlacklistRepository) {
        this.authenticationService = authenticationService;
        this.tokenBlacklistRepository = tokenBlacklistRepository;
    }


    @PostMapping("/register")
    public ResponseEntity<AuthResponse> register(@RequestBody RegisterRequest request) {
        return ResponseEntity.ok(authenticationService.register(request));
    }

    @PostMapping("/login")
    public ResponseEntity<AuthResponse> login(@RequestBody LoginRequest request) {
        return ResponseEntity.ok(authenticationService.login(request));
    }

    @PostMapping("/logout")
    public ResponseEntity<String> logout(@RequestHeader("Authorization") String authHeader) {
        String token = authHeader.replace("Bearer ", "");
        tokenBlacklistRepository.blacklistToken(token);
        return ResponseEntity.ok("Token invalidado correctamente");
    }
}
